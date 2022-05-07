<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\ProductTag;
use App\Http\Requests\TagRequest;
use App\Models\CssColor;

class TagController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return Tag::where("label", $lbl)->exists();
        else return Tag::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    public function index(){
        $tags = Tag::paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    public function create(){
        return view('admin.tags.create');
    }

    public function store(TagRequest $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That tag already exists.')])->withInput(); //Redirect back with a custom error and older Inputs

        $tag = new Tag([
            'label' => $request->label, 
            'border_css_color_id' => $this->getCssClassId($request, 'border'),
            'text_css_color_id' => $this->getCssClassId($request, 'text'),
            'bg_css_color_id' => $this->getCssClassId($request, 'bg'),
        ]);
        $tag->save();
        return redirect()->route('tags.index')->with('info', __('The tag has been created.'));
    }
    
    public function edit(Tag $tag){
        return view('admin.tags.edit', compact('tag'));
    }
    
    public function update(TagRequest $request, Tag $tag){
        if($this->exists($request->label, $tag->id))
            return back()->withErrors(['label' => __('That tag already exists.')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $tag->update($request
            ->merge([
                'label' => $request->label,
                'border_css_color_id' => $this->getCssClassId($request, 'border'),
                'text_css_color_id' => $this->getCssClassId($request, 'text'),
                'bg_css_color_id' => $this->getCssClassId($request, 'bg'),
            ])
            ->all()
        );
        return redirect()->route('tags.index')->with('info', __('The tag has been edited.'));
    }
    
    public function destroy(Tag $tag){
        ProductTag::where('tag_id', '=', $tag->id)->delete();
        $tag->delete();
        return redirect()->route('tags.index')->with('info', __('The tag has been deleted.'));
    }

    public function getCssClassId(TagRequest $request, $kind = 'border'){
        $css_class = (Object)[
            'class' => $request->{$kind.'_color'}.(($request->{$kind.'_variant'} === 'none')? '' : ('-'.$request->{$kind.'_variant'})), 
            'text_color' => null
        ];
        return CssColor::where('css_class', '=', $css_class->class)->first()->id;
    }
}
