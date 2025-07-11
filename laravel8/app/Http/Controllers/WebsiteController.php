<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebsiteRequest;
use App\Models\Website;

class WebsiteController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return Website::where("label", $lbl)->exists();
        else return Website::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    //Routes
    public function index(){
        $websites = Website::paginate(10);
        return view('admin.websites.index', compact('websites'));
    }

    public function create(){
        return view('admin.websites.create');
    }

    public function store(WebsiteRequest $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That website already exists.')])->withInput(); //Redirect back with a custom error and older Inputs

        $website = new Website([
            'label' => $request->label, 
            'url' => $request->url,
            'can_sell' => $request->has('can_sell')? 1 : 0,
            'is_vg' => $request->has('is_vg')? 1 : 0,
            'is_crowdfunding' => $request->has('is_crowdfunding')? 1 : 0,
        ]);
        $website->save();
        return redirect()->route('websites.index')->with('info', __('The website has been created.'));
    }

    public function edit(Website $website){
        return view('admin.websites.edit', compact('website'));
    }

    public function update(WebsiteRequest $request, Website $website){
        if($this->exists($request->label, $website->id))
            return back()->withErrors(['label' => __('That website already exists.')])->withInput(); //Redirect back with a custom error and older Inputs

        $website->update($request
            ->merge([
                'can_sell' => ($request->has('can_sell')? 1 : 0),
                'is_vg' => ($request->has('is_vg')? 1 : 0),
                'is_crowdfunding' => ($request->has('is_crowdfunding')? 1 : 0),
            ])
            ->all()
        );
        return redirect()->route('websites.index')->with('info', __('The website has been edited.'));
    }

    public function destroy(Website $website){
        $website->delete();
        return back()->with('info', __('The website has been deleted.'));
    }
}
