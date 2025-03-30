<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Book;
use App\Models\BookPublisher;
use App\Models\Product;
use App\Models\ProductAsVideoGame;
use App\Models\VgSupport;

class ProductTemplateController extends Controller
{
    const TYPES = ['video_game', 'vg_support', 'publisher'];
    
    public function delete($productId, $types = self::TYPES){
        foreach($types as $type){
            if($type === 'video_game'){
                $productVg = ProductAsVideoGame::where('product_id', '=', $productId);
                $productVg->delete();
            }elseif($type === 'vg_support'){
                $supportVg = VgSupport::where('product_id', '=', $productId);
                $supportVg->update(['product_id' => null]);
            }elseif($type === 'publisher'){
                $book = Book::where('product_id', '=', $productId);
                $book->update(['product_id' => null]);
            }
        }
    }

    public function update($product, $type, $templateIds){
        $template = $product->get_template();

        if($template->id === (int)$templateIds[$type] && $template->type === $type) return; //No change on the template
        $this->delete($product->id);
        switch($type){
            case 'video_game':
                $vg = new ProductAsVideoGame([
                    'product_id' => $product->id,
                    'video_game_id' => $templateIds['video_game'],
                    'vg_support_id' => $templateIds['vg_support'],
                ]);
                $vg->save();
                break;
            case 'vg_support':
                $support = VgSupport::find($templateIds['vg_support']);
                $support->update(['product_id' => $product->id]);
                break;
            case 'publisher':
                $publisher = BookPublisher::find($templateIds['publisher']);
                Book::updateOrCreate(
                    ['book_publisher_id' => $publisher->id],
                    ['product_id' => $product->id],
                );
                break;
        }
    }

    //Updating product's template
    public static function updateProduct(ProductRequest $request, Product $product){
        $template = new ProductTemplateController($product->id);
        $templates = [
            'video_game' => $request->lk_video_game,
            'vg_support' => $request->lk_vg_support,
            'publisher' => $request->lk_publisher,
            'none' => null,
        ];
        $template->update($product, $request->template_type, $templates);
    }
}
