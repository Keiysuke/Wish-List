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
        $product_states = ProductState::paginate(10);
        return view('admin.states.products.index', compact('product_states'));
    }

    public function create(){
        return view('admin.states.products.create');
    }

    public function store(Request $request, ProductState $product_state){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs
            
        $product_state = new ProductState(['label' => $request->label]);
        $product_state->save();
        return redirect()->route('states.products.index')->with('info', __('The state has been saved.'));
    }

    public function edit(ProductState $product_state){
        return view('admin.states.products.edit', compact('product_state'));
    }
    
    public function update(Request $request, ProductState $product_state){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label, $product_state->id))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs

        $product_state->update($request->all());
        return redirect()->route('states.products.index')->with('info', __('The state has been edited.'));
    }

    public function destroy(ProductState $product_state){
        $product_state->delete();
        return back()->with('info', __('The state has been deleted.'));
    }
}
