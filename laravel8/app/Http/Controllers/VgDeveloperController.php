<?php

namespace App\Http\Controllers;

use App\Models\VgDeveloper;
use App\Http\Requests\VgDeveloperRequest;

class VgDeveloperController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return VgDeveloper::where("label", $lbl)->exists();
        else return VgDeveloper::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    //Routes
    public function index(){
        $vg_developers = VgDeveloper::paginate(10);
        return view('admin.vg_developers.index', compact('vg_developers'));
    }

    public function create(){
        return view('admin.vg_developers.create');
    }

    public function store(VgDeveloperRequest $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That video game developer already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $vg_developer = new VgDeveloper([
            'label' => $request->label,
            'description' => $request->description,
            'year_created' => $request->year_created,
        ]);
        $vg_developer->save();

        return redirect()->route('vg_developers.index')->with('info', __('The video game developer has been saved.'));
    }

    public function edit(VgDeveloper $vg_developer){
        return view('admin.vg_developers.edit', compact('vg_developer'));
    }
    
    public function update(VgDeveloperRequest $request, VgDeveloper $vg_developer){
        if($this->exists($request->label, $vg_developer->id))
            return back()->withErrors(['label' => __('That video game developer already exists')])->withInput(); //Redirect back with a custom error and older Inputs

        $vg_developer->update($request->all());
        return redirect()->route('vg_developers.index')->with('info', __('The video game developer has been edited.'));
    }

    public function destroy(VgDeveloper $vg_developer){
        $vg_developer->delete();
        return back()->with('info', __('The video game developer has been deleted.'));
    }
}
