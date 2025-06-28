<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->paginate(15);
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country_id' => 'required|exists:countries,id',
        ]);
        City::create($validated);
        return redirect()->route('cities.index')->with('info', 'La ville a été ajoutée.');
    }

    public function edit(City $city)
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.cities.edit', compact('city', 'countries'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country_id' => 'required|exists:countries,id',
        ]);
        $city->update($validated);
        return redirect()->route('cities.index')->with('info', 'La ville a été modifiée.');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return back()->with('info', 'La ville a été supprimée.');
    }
}
