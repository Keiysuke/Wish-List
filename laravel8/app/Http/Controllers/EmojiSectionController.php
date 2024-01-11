<?php

namespace App\Http\Controllers;

use App\Models\EmojiSection;
use Illuminate\Http\Request;

class EmojiSectionController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return EmojiSection::where("label", $lbl)->exists();
        else return EmojiSection::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    public function index(){
        $sections = EmojiSection::paginate(10);
        return view('admin.sections.emojis.index', compact('sections'));
    }

    public function create(){
        return view('admin.sections.emojis.create');
    }

    public function store(Request $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That emoji section already exists.')])->withInput(); //Redirect back with a custom error and older Inputs

        $section = new EmojiSection([
            'label' => $request->label, 
        ]);
        $section->save();
        return redirect()->route('sections.emojis.index')->with('info', __('The section has been created.'));
    }
    
    public function edit(EmojiSection $section){
        return view('admin.sections.emojis.edit', compact('section'));
    }
    
    public function update(Request $request, EmojiSection $section){
        if($this->exists($request->label, $section->id))
            return back()->withErrors(['label' => __('That section already exists.')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $section->update($request
            ->merge([
                'label' => $request->label,
                'emoji_section_id' => $request->section_id,
            ])
            ->all()
        );
        return redirect()->route('sections.emojis.index')->with('info', __('The section has been edited.'));
    }
    
    public function destroy(EmojiSection $section){
        $section->delete();
        return redirect()->route('sections.emojis.index')->with('info', __('The section has been deleted.'));
    }
}
