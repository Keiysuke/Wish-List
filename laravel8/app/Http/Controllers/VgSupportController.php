<?php

namespace App\Http\Controllers;

use App\Models\VgSupport;
use App\Http\Requests\VgSupportRequest;

class VgSupportController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return VgSupport::where("label", $lbl)->exists();
        else return VgSupport::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    //Routes
    public function index(){
        $vgSupports = VgSupport::paginate(10);
        return view('admin.vg_supports.index', compact('vgSupports'));
    }

    public function create(){
        return view('admin.vg_supports.create');
    }

    public function store(VgSupportRequest $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That video game support already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $vgSupport = new VgSupport([
            'product_id' => $request->product_id,
            'label' => $request->label,
            'alias' => $request->alias,
            'date_released' => $request->date_released,
            'price' => str_replace(',', '.', $request->price),
        ]);
        $vgSupport->save();

        return redirect()->route('vg_supports.index')->with('info', __('The video game support has been saved.'));
    }

    public function edit(VgSupport $vgSupport){
        return view('admin.vg_supports.edit', compact('vgSupport'));
    }
    
    public function update(VgSupportRequest $request, VgSupport $vgSupport){
        if($this->exists($request->label, $vgSupport->id))
            return back()->withErrors(['label' => __('That video game support already exists')])->withInput(); //Redirect back with a custom error and older Inputs

        $vgSupport->update($request->all());
        return redirect()->route('vg_supports.index')->with('info', __('The video game support has been edited.'));
    }

    public function destroy(VgSupport $vgSupport){
        $vgSupport->delete();
        return back()->with('info', __('The video game support has been deleted.'));
    }
}
