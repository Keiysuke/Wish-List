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
        $sell_states = SellState::paginate(10);
        return view('admin.states.sells.index', compact('sell_states'));
    }

    public function create(){
        return view('admin.states.sells.create');
    }

    public function store(Request $request, SellState $sell_state){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $sell_state = new SellState(['label' => $request->label]);
        $sell_state->save();
        return redirect()->route('states.sells.index')->with('info', __('The state has been saved.'));
    }

    public function edit(SellState $sell_state){
        return view('admin.states.sells.edit', compact('sell_state'));
    }
    
    public function update(Request $request, SellState $sell_state){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label, $sell_state->id))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $sell_state->update($request->all());
        return redirect()->route('states.sells.index')->with('info', __('The state has been edited.'));
    }

    public function destroy(SellState $sell_state){
        $sell_state->delete();
        return back()->with('info', __('The state has been deleted.'));
    }
}
