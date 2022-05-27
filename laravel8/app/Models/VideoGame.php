<?php

namespace App\Models;

use App\Http\Controllers\UtilsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\VgDeveloper;

class VideoGame extends Model
{
    use HasFactory;
    protected $fillable = ['developer_id', 'label', 'date_released', 'nb_players'];

    public function developer(){
        return $this->belongsTo(VgDeveloper::class);
    }

    public function products(){
        return $this->hasMany(ProductAsVideoGame::class);
    }

    public function vg_supports(){
        return $this->hasMany(ProductAsVideoGame::class);
    }

    public function date_released($format = 'd/m/Y'){
        return UtilsController::getDate($this->date_released, $format);
    }

    public function product(){
        $products = $this->products;
        return (count($products) > 0)? $products->first()->product : null;
    }
    
    public function support(){
        $products = $this->products;
        return (count($products) > 0)? $products->first()->support : null;
    }

    /** 
     * Return an array containing datas corresponding if the JV has successfully been linked to a product/support
     * @param int $support_id
     * @return array
    */
    public function fast_link_product($support_id = null){
        $products = Product::where('label', 'like', '%'.$this->label.'%')
            ->orWhere('label', 'like', '%'.str_replace(': ', '%', $this->label).'%')
            ->get();
        if(count($products) === 1){
            $product = $products->first();

            if (is_null($support_id)) {
                $supports = VgSupport::all();
                foreach($supports as $support){
                    if(strpos($product->label, $support->alias) === false) continue;
                    $support_id = $support->id;
                }
            }

            if (!is_null($support_id)) { //If it's still null, we can't link
                $pvg = ProductAsVideoGame::where('video_game_id', '=', $this->id)
                    ->where('vg_support_id', '=', $support_id)
                    ->where('product_id', '=', $product->id)
                    ->get();
                
                if (count($pvg) > 0) { //Already linked to a product
                    $pvg = $pvg->first();
                    if ($pvg->video_game_id !== $this->id) {
                        return ['success' => true, 'msg' => 'Linked to another product : '.$pvg->video_game_id];
                    } else {
                        return ['success' => true, 'msg' => 'Already linked to that product'];
                    }
                } else { //Linking to the product found
                    $pvg = new ProductAsVideoGame([
                        'product_id' => $product->id, 
                        'video_game_id' => $this->id, 
                        'vg_support_id' => $support_id, 
                    ]);
                    $pvg->save();
                }
                return ['success' => true, 'msg' => 'Correctly linked to product'];
            }
        }
        return ['success' => false, 'msg' => 'No product found'];
    }
}
