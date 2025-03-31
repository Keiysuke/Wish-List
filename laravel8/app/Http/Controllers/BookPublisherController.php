<?php

namespace App\Http\Controllers;

use App\Models\BookPublisher;
use App\Http\Requests\BookPublisherRequest;

class BookPublisherController extends Controller
{
    public function exists($lbl, $id = null){
        if(is_null($id)) return BookPublisher::where("label", $lbl)->exists();
        else return BookPublisher::where('label', $lbl)->where('id', '<>', $id)->exists();
    }

    //Routes
    public function index(){
        $publishers = BookPublisher::paginate(10);
        return view('admin.book_publishers.index', compact('publishers'));
    }

    public function create(){
        return view('admin.book_publishers.create');
    }

    public function store(BookPublisherRequest $request){
        if($this->exists($request->label))
            return back()->withErrors(['label' => __('That publisher already exists')])->withInput(); //Redirect back with a custom error and older Inputs
        
        $publisher = new BookPublisher([
            'label' => $request->label,
            'description' => $request->description,
            'founded_year' => $request->founded_year,
            'country' => $request->country,
            'website_id' => $request->website_id,
            'active' => $request->has('active')? 1 : 0,
        ]);
        $publisher->save();

        return redirect()->route('book_publishers.index')->with('info', __('The publisher has been saved.'));
    }

    public function edit(BookPublisher $publisher){
        return view('admin.book_publishers.edit', compact('publisher'));
    }
    
    public function update(BookPublisherRequest $request, BookPublisher $publisher){
        if($this->exists($request->label, $publisher->id))
            return back()->withErrors(['label' => __('That publisher already exists')])->withInput();

        $publisher->update($request
            ->merge([
                'active' => ($request->has('active')? 1 : 0),
            ])
            ->all()
        );
        return redirect()->route('book_publishers.index')->with('info', __('The publisher has been edited.'));
    }

    public function destroy(BookPublisher $publisher){
        $publisher->delete();
        return back()->with('info', __('The publisher has been deleted.'));
    }
}
