<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::paginate(15);
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
        ]);
        Country::create($validated);
        return redirect()->route('countries.index')->with('info', 'Le pays a été ajouté.');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
        ]);
        $country->update($validated);
        return redirect()->route('countries.index')->with('info', 'Le pays a été modifié.');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return back()->with('info', 'Le pays a été supprimé.');
    }
}
