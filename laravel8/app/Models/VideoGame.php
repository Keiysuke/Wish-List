<?php

namespace App\Models;

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProductPhotoController;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\VgDeveloper;

class VideoGame extends Model
{
    use HasFactory;
    protected $fillable = ['developer_id', 'label', 'date_released', 'nb_players'];
    public $product = null;

    public function developer(){
        return $this->belongsTo(VgDeveloper::class);
    }

    public function products(){
        return $this->hasMany(ProductAsVideoGame::class);
    }
    
    public function creator(){
        return $this->hasOne(User::class, 'id', 'created_by')->first();
    }

    public function vg_supports(){
        return $this->hasMany(ProductAsVideoGame::class);
    }

    public function description(): String {
        return ($this->product())->description ?? '';
    }

    public function date_released($format = 'd/m/Y'){
        return DateService::getDate($this->date_released, $format);
    }

    public function product(){
        if (!is_null($this->product)) {
            return $this->product;
        }
        
        $this->setFirstPhoto();
        if (count($this->products) > 0) {
            $this->product = $this->products->first()->product;
            return $this->product;
        }
        return null;
    }
    
    public function support(){
        $products = $this->products;
        return (count($products) > 0)? $products->first()->vg_support : null;
    }

    public function setFirstPhoto(){
        if (count($this->products) > 0) {
            $product = $this->products->first()->product;
            $product->setFirstPhoto();
            $this->pict = $product->pict;
        } else {
            $this->pict = asset(ProductPhotoController::getPhotoLink(null));
        }
    }

    public function getStudioAsLink(){
        $dev = $this->developer;
        if (is_null($dev)) {
            return '<a href="'.route('vg_developers.create').'" class="link" target="_blank">Indéfini</a>';
        }
        return '<a href="'.route('vg_developers.edit', $dev->id).'" class="link" target="_blank">'.$dev->label.'</a>';
    }

    /** 
     * Return an array containing datas corresponding if the JV has successfully been linked to a product/support
     * @param int $supportId
     * @return array
    */
    public function fast_link_product($supportId = null){
        $products = Product::where('label', 'like', '%'.$this->label.'%')
            ->orWhere('label', 'like', '%'.str_replace(': ', '%', $this->label).'%')
            ->get();
        if(count($products) === 1){
            $product = $products->first();

            if (is_null($supportId)) {
                $supports = VgSupport::all();
                foreach($supports as $support){
                    if(strpos($product->label, $support->alias) === false) continue;
                    $supportId = $support->id;
                }
            }

            if (is_null($supportId)) { //If it's still null, we can't link
                return ['success' => false, 'notyf' => Notyf::error('No support (PS4, PC...) found on the product\'s name')];
            }
            
            $pvg = ProductAsVideoGame::where('video_game_id', '=', $this->id)
                ->where('vg_support_id', '=', $supportId)
                ->where('product_id', '=', $product->id)
                ->get();
            
            if (count($pvg) > 0) { //Already linked to a product
                $pvg = $pvg->first();
                if ($pvg->video_game_id !== $this->id) {
                    return ['success' => false, 'notyf' => Notyf::error('Linked to another product : '.$pvg->video_game_id)];
                } else {
                    return ['success' => false, 'notyf' => Notyf::warning('Already linked to that product')];
                }
            } else { //Linking to the product found
                $pvg = new ProductAsVideoGame([
                    'product_id' => $product->id, 
                    'video_game_id' => $this->id, 
                    'vg_support_id' => $supportId, 
                ]);
                $pvg->save();
            }
            //Suppression d'une notification si jamais elle existe
            NotificationsController::deleteFrom('MissingProductOnVideoGame', $this->id);
            return ['success' => true, 'notyf' => Notyf::success('Correctly linked to product'), 'productId' => $product->id];
        }
        return ['success' => false, 'notyf' => Notyf::warning('No product found')];
    }
}
