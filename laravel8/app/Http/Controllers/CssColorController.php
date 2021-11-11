<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CssColor;
use App\Models\Tag;

class CssColorController extends Controller
{
    function get_variants(Request $request){
        if ($request->ajax()) {
            $this->validate($request, ['color' => 'bail|required|string']); //New selected color
            $variants = CssColor::select('css_class')->where('css_class', 'like', $request->color.'%')->get();

            $res = [];
            foreach($variants as $variant){
                $details = explode('-', $variant);
                $res[] = (count($details) > 1)? substr($details[1], 0, -2) : '';
            }
            $variant = $request->cur_variant ?? '';
            $variant = in_array($variant, $res)? $variant : $res[0];
            $returnHTML = view('partials.tags.select_variants')->with(['variants' => $res, 'selected' => $variant])->render();
            $css_class = $request->color.(empty($variant)? '' : '-'.$variant);
            $returnTag = view('components.tags.tag')->with(['tag' => Tag::getExample(CssColor::where('css_class', '=', $css_class)->first()->id)])->render();
            
            return response()->json(['success' => true, 'html' => $returnHTML, 'tag' => $returnTag]);
        }
    }
}
