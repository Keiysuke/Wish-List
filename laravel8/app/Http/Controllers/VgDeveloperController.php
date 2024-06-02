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
        $vgDevelopers = VgDeveloper::paginate(10);
        return view('admin.vg_developers.index', compact('vgDevelopers'));
    }

    public function create(){
        return view('admin.vg_developers.create');
    }

    public function store(VgDeveloperRequest $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That video game developer already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $vgDeveloper = new VgDeveloper([
            'label' => $request->label,
            'description' => $request->description,
            'year_created' => $request->year_created,
        ]);
        $vgDeveloper->save();

        return redirect()->route('vg_developers.index')->with('info', __('The video game developer has been saved.'));
    }

    public function edit(VgDeveloper $vgDeveloper){
        return view('admin.vg_developers.edit', compact('vgDeveloper'));
    }
    
    public function update(VgDeveloperRequest $request, VgDeveloper $vgDeveloper){
        if($this->exists($request->label, $vgDeveloper->id))
            return back()->withErrors(['label' => __('That video game developer already exists')])->withInput(); //Redirect back with a custom error and older Inputs

        $vgDeveloper->update($request->all());
        return redirect()->route('vg_developers.index')->with('info', __('The video game developer has been edited.'));
    }

    public function destroy(VgDeveloper $vgDeveloper){
        $vgDeveloper->delete();
        return back()->with('info', __('The video game developer has been deleted.'));
    }
}
