<?php

namespace App\Services;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseService
{
    public function createFromRequest(Request $request): Purchase
    {
        return Purchase::create(
            $request->merge([
                'cost' => str_replace(',', '.', $request->cost),
                'discount' => str_replace(',', '.', $request->discount ?? 0),
                'customs' => str_replace(',', '.', $request->customs ?? 0),
            ])->all()
        );
    }
}