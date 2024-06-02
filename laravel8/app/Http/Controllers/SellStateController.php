<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellState;
use App\Rules\StateLabel;

class SellStateController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return SellState::where("label", $lbl)->exists();
        else return SellState::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    //Routes
    public function index(){
        $sellStates = SellState::paginate(10);
        return view('admin.states.sells.index', compact('sellStates'));
    }

    public function create(){
        return view('admin.states.sells.create');
    }

    public function store(Request $request, SellState $sellState){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $sellState = new SellState(['label' => $request->label]);
        $sellState->save();
        return redirect()->route('states.sells.index')->with('info', __('The state has been saved.'));
    }

    public function edit(SellState $sellState){
        return view('admin.states.sells.edit', compact('sellState'));
    }
    
    public function update(Request $request, SellState $sellState){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label, $sellState->id))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $sellState->update($request->all());
        return redirect()->route('states.sells.index')->with('info', __('The state has been edited.'));
    }

    public function destroy(SellState $sellState){
        $sellState->delete();
        return back()->with('info', __('The state has been deleted.'));
    }
}
