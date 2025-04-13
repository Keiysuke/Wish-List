<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\User;
use App\Services\UploadService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductPhotoController extends Controller
{
    public function edit(Product $product){
        $photos = $product->photos()->orderBy('ordered')->get();
        return view('products.photos.edit', compact('product', 'photos'));
    }
    
    public function update(Request $request, Product $product){
        $rules = [];
        //Validation des photos
        for($i = 1; $i <= $request->nb_photos; $i++){
            $photo = $product->photos()->firstWhere('ordered', $i);
            //On vérifie la validation s'il y a une nouvelle photo ou qu'aucune autre n'existait avant
            if(!is_null($request['photo_'.$i]) || is_null($photo)) $rules['photo_'.$i] = 'required|image|dimensions:dimensions:min_width=100,min_height=100';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return back()->withInput($request->input())->withErrors($validator->errors());
        
        //On met à jour les notifications au sujet des photos du produit
        $this->delNotifMissingPhoto($product);

        $dir = config('images.path_products').'/'.$product->id;
        //Suppression des photos
        $deletedPhotos = $product->photos()->where('ordered', '>', $request->nb_photos)->get();
        foreach($deletedPhotos as $p){
            $p->delete();
            File::delete(public_path().'/'.$dir.'/'.$p->label);
        }
        //Réorganisation si supression
        for($i = $request->nb_photos; $i > 0; $i--){
            if(!is_null($request['del_photo_'.$i]) || !is_null($request['photo_'.$i])){
                $p = ProductPhoto::where(['product_id' => $product->id, 'ordered' => $i])->first();
                if(is_null($p)) continue;

                $f = public_path().'/'.$dir.'/'.$p->label;
                if(File::exists($f)) File::delete($f);
                $p->delete();
                //Reorder
                ProductPhoto::where('product_id', $product->id)->where('ordered', '>', $i)
                    ->chunkById(10, function ($photos) {
                        $photos->each(function($photo){
                            $ext = explode('.', $photo->label);
                            $order = $photo->ordered-1;
                            //Rename file
                            $dir = config('images.path_products').'/'.$photo->product_id;
                            File::move($dir.'/'.$photo->ordered.'.'.$ext[1], $dir.'/'.$order.'.'.$ext[1]);
                            $photo->update(['ordered' => $order, 'label' => $order.'.'.$ext[1]]);
                        });
                    }, $column = 'id');
            }
        }
        
        //Upload des nouvelles (si nécessaire)
        for($i = 1; $i <= $request->nb_photos; $i++){
            if(!array_key_exists('photo_'.$i, $rules)) continue;

            UploadService::storePhoto($request, $i, $product);
        }
        return redirect()->route('products.show', $product->id)->with('info', __('Photos have been edited.'));
    }

    public static function getPhotoLink($photo, $dir = ''){
        if (is_null($photo)) {
            return 'resources/images/no_pict.png';
        }
        return $dir.$photo->label;
    }

    public static function delNotifMissingPhoto($product){
        $user = User::find(auth()->user()->id);
        $notif = $user->notifications()->where('type', '=', 'App\Notifications\MissingPhotos')->whereJsonContains('data->product_id', $product->id)->first();
        if(!is_null($notif)){
            $notif->delete();
        }
    }
}
