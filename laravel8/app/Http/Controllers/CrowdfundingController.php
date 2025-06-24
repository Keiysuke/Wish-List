<?php

namespace App\Http\Controllers;

use App\Models\Crowdfunding;
use App\Services\CrowdfundingService;
use App\Models\Product;
use App\Models\Website;
use Illuminate\Http\Request;

class CrowdfundingController extends Controller
{
    public function create()
    {
        $products = Product::all();
        $websites = Website::where('is_crowdfunding', true)->get();
        return view('crowdfundings.create', compact('products', 'websites'));
    }

    public function store(Request $request)
    {
        $crowdfunding = (new CrowdfundingService())->createFromRequest($request);
        return redirect()->route('products.show', ['product' => $crowdfunding->product])->with('info', 'Projet participatif ajouté !');
    }

    public function edit(Crowdfunding $crowdfunding)
    {
        $products = Product::all();
        $websites = Website::where('is_crowdfunding', true)->get();
        return view('crowdfundings.edit', compact('crowdfunding', 'products', 'websites'));
    }

    public function update(Request $request, Crowdfunding $crowdfunding)
    {
        $crowdfunding->update($request->all());
        return redirect()->route('products.show', ['product' => $crowdfunding->product])->with('info', 'Projet participatif mis à jour !');
    }

    public function createForProduct(Product $product)
    {
        $websites = \App\Models\Website::where('is_crowdfunding', true)->get();
        $crowdfundingStates = \App\Models\CrowdfundingState::orderBy('label')->get();
        return view('products.crowdfundings.create', compact('product', 'websites', 'crowdfundingStates'));
    }
}
