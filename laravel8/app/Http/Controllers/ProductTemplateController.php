<?php

namespace App\Http\Controllers;

use App\Models\ProductAsVideoGame;
use App\Models\VgSupport;
use App\Models\VideoGame;
use Illuminate\Http\Request;

class ProductTemplateController extends Controller
{
    const TYPES = ['video_game', 'vg_support'];
    
    public function delete($product_id, $types = self::TYPES){
        foreach($types as $type){
            if($type === 'video_game'){
                $product_vg = ProductAsVideoGame::where('product_id', '=', $product_id);
                $product_vg->delete();
            }elseif($type === 'vg_support'){
                $product = VgSupport::where('product_id', '=', $product_id);
                $product->update(['product_id' => null]);
            }
        }
    }

    public function update($product, $type, $template_ids){
        $template = $product->get_template();

        if($template->id === (int)$template_ids[$type] && $template->type === $type) return; //No change on the template
        switch($type){
            case 'video_game':
                $this->delete($product->id, ['vg_support']);
                $pvg = new ProductAsVideoGame([
                    'product_id' => $product->id,
                    'video_game_id' => $template_ids['video_game'],
                    'vg_support_id' => $template_ids['vg_support'],
                ]);
                $pvg->save();
                break;
            case 'vg_support':
                $this->delete($product->id, ['video_game']);
                $support = VgSupport::find($template_ids['vg_support']);
                $support->update(['product_id' => $product->id]);
                break;
            case 'none':
                $this->delete($product->id, ['video_game']);
                $this->delete($product->id, ['vg_support']);
                break;
        }
    }
}
