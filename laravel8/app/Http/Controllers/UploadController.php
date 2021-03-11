<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductPhoto;

class UploadController extends Controller
{
    public function storePhoto($request, $nb, $product){
        $dir = config('images.path_products').'/'.$product->id;
        $ext = '.'.$request['photo_'.$nb]->getClientOriginalExtension();

        $new_nb = $nb;
        //Des photos ont pu être supprimées avant l'upload des nouvelles, il faut alors redéfinir l'ordre des nouvelles
        if(!is_null($request->nb_photos)){
            for($i = 1; $i <= $request->nb_photos; $i++){
                if(!is_null($request['del_photo_'.$i])) $new_nb--;
            }
        }
        $request['photo_'.$nb]->storeAs($dir, $new_nb.$ext, 'public');
        $photo = ProductPhoto::firstOrNew(['product_id' => $product->id, 'ordered' => $new_nb]);
        $photo->label = $new_nb.$ext;
        $photo->save();
    }
}
