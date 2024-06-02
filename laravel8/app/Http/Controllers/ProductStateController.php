<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductState;
use App\Rules\StateLabel;

class ProductStateController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return ProductState::where("label", $lbl)->exists();
        else return ProductState::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    //Routes
    public function index(){
        $productStates = ProductState::paginate(10);
        return view('admin.states.products.index', compact('productStates'));
    }

    public function create(){
        return view('admin.states.products.create');
    }

    public function store(Request $request, ProductState $productState){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $productState = new ProductState(['label' => $request->label]);
        $productState->save();
        return redirect()->route('states.products.index')->with('info', __('The state has been saved.'));
    }

    public function edit(ProductState $productState){
        return view('admin.states.products.edit', compact('productState'));
    }
    
    public function update(Request $request, ProductState $productState){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label, $productState->id))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs

        $productState->update($request->all());
        return redirect()->route('states.products.index')->with('info', __('The state has been edited.'));
    }

    public function destroy(ProductState $productState){
        $productState->delete();
        return back()->with('info', __('The state has been deleted.'));
    }
}
