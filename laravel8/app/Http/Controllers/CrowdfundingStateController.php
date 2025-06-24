<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrowdfundingState;
use App\Rules\StateLabel;

class CrowdfundingStateController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return CrowdfundingState::where("label", $lbl)->exists();
        else return CrowdfundingState::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    //Routes
    public function index(){
        $crowdfundingStates = CrowdfundingState::paginate(10);
        return view('admin.states.sells.index', compact('crowdfundingStates'));
    }

    public function create(){
        return view('admin.states.sells.create');
    }

    public function store(Request $request, CrowdfundingState $crowdfundingState){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $crowdfundingState = new CrowdfundingState(['label' => $request->label]);
        $crowdfundingState->save();
        return redirect()->route('states.sells.index')->with('info', __('The state has been saved.'));
    }

    public function edit(CrowdfundingState $crowdfundingState){
        return view('admin.states.sells.edit', compact('crow$crowdfundingState'));
    }
    
    public function update(Request $request, CrowdfundingState $crowdfundingState){
        $this->validate($request, ['label' => new StateLabel]);
        if($this->exists($request->label, $crowdfundingState->id))
            return back()->withErrors(['label' => __('That state already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $crowdfundingState->update($request->all());
        return redirect()->route('states.sells.index')->with('info', __('The state has been edited.'));
    }

    public function destroy(CrowdfundingState $crowdfundingState){
        $crowdfundingState->delete();
        return back()->with('info', __('The state has been deleted.'));
    }
}
