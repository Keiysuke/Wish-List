<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\PublisherType;
use App\Http\Requests\BookPublisherRequest;
use App\Models\City;

class BookPublisherController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return Publisher::where("label", $lbl)->where('type_id', PublisherType::BOOK)->exists();
        else return Publisher::where('label', $lbl)->where('id', '<>', $id)->where('type_id', PublisherType::BOOK)->exists();
    }

    //Routes
    public function index(){
        $publishers = Publisher::all()->paginate(10);
        return view('admin.book_publishers.index', compact('publishers'));
    }

    public function create(){
        $cities = City::orderBy('name')->get();
        return view('admin.book_publishers.create', compact('cities'));
    }

    public function store(BookPublisherRequest $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That publisher already exists')])->withInput();
        
        Publisher::create(
            $request->merge([
                'active' => $request->has('active')? 1 : 0,
            ])->all()
        );

        return redirect()->route('book_publishers.index')->with('info', __('The publisher has been saved.'));
    }

    public function edit(Publisher $publisher){
        $cities = City::orderBy('name')->get();
        return view('admin.book_publishers.edit', compact('publisher', 'cities'));
    }
    
    public function update(BookPublisherRequest $request, Publisher $publisher){
        if($this->exists($request->label, $publisher->id))
            return back()->withErrors(['label' => __('That publisher already exists')])->withInput();

        $publisher->update(
            $request->merge([
                'active' => ($request->has('active')? 1 : 0),
            ])->all()
        );
        return redirect()->route('book_publishers.index')->with('info', __('The publisher has been edited.'));
    }

    public function destroy(Publisher $publisher){
        $publisher->delete();
        return back()->with('info', __('The publisher has been deleted.'));
    }
}
