<?php

namespace App\Http\Controllers;

use App\Models\Emoji;
use App\Services\DesignService;
use Illuminate\Http\Request;

class EmojiController extends Controller
{
    public function exists(string $label, ?int $id = null): bool
    {
        if(is_null($id)) return Emoji::where("label", $label)->exists();
        else return Emoji::where('label', $label)->where('id', '<>', $id)->exists();
    }

    public function index(){
        $emojis = Emoji::paginate(10);
        return view('admin.emojis.index', compact('emojis'));
    }

    public function create(){
        return view('admin.emojis.create');
    }

    public function store(Request $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That emoji already exists.')])->withInput(); //Redirect back with a custom error and older Inputs

        Emoji::create($request->all());
        return redirect()->route('emojis.index')->with('info', __('The emoji has been created.'));
    }
    
    public function edit(Emoji $emoji){
        return view('admin.emojis.edit', compact('emoji'));
    }
    
    public function update(Request $request, Emoji $emoji){
        if($this->exists($request->label, $emoji->id))
            return back()->withErrors(['label' => __('That emoji already exists.')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $emoji->update($request->all());
        return redirect()->route('emojis.index')->with('info', __('The emoji has been edited.'));
    }
    
    public function destroy(Emoji $emoji){
        $emoji->delete();
        return redirect()->route('emojis.index')->with('info', __('The emoji has been deleted.'));
    }

    public function renderIcon(String $kind){
        return response()->json(['success' => true, 'html' => DesignService::getAnimIcon($kind)]);
    }
}
