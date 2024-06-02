<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CssColor;
use App\Models\Tag;

class CssColorController extends Controller
{
    function get_variants(Request $request){
        if ($request->ajax()) {
            $this->validate($request, [
                'border_color' => 'bail|required|string',
                'text_color' => 'bail|required|string',
                'bg_color' => 'bail|required|string',
                'kind' => 'bail|required|string'
            ]); //New selected color
            $kinds = ['border', 'text', 'bg'];
            $cssClasses = [];
            foreach($kinds as $kind){
                $variants = CssColor::select('css_class')->where('css_class', 'like', $request->{$kind.'_color'}.'%')->get();
                $res = [];
                foreach($variants as $variant){
                    $details = explode('-', $variant);
                    $res[] = (count($details) > 1)? substr($details[1], 0, -2) : '';
                }
                $variant = $request->{$kind.'_cur_variant'} ?? '';
                $variant = in_array($variant, $res)? $variant : $res[0];
                $cssClasses[$kind] = $request->{$kind.'_color'}.(empty($variant)? '' : '-'.$variant);

                if($kind === $request->kind)
                    $returnHTML = view('partials.tags.select_variants')->with(['variants' => $res, 'selected' => $variant])->render();
            }
            //Set the tag
            $exTag = Tag::getExample(
                CssColor::where('css_class', '=', $cssClasses['border'])->first()->id,
                CssColor::where('css_class', '=', $cssClasses['text'])->first()->id,
                CssColor::where('css_class', '=', $cssClasses['bg'])->first()->id
            );
            $returnTag = view('components.tags.tag')->with(['tag' => $exTag])->render();
            
            return response()->json(['success' => true, 'html' => $returnHTML, 'tag' => $returnTag]);
        }
    }
}
