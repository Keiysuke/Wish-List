<?php

namespace App\Services;

use App\Models\TravelStep;
use Illuminate\Http\Request;

class TravelStepService
{
    public function createFromRequest(Request $request): TravelStepService
    {
        return TravelStep::create($request->all());
    }
}
