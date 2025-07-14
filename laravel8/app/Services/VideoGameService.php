<?php

namespace App\Services;

use App\Models\VideoGame;
use Illuminate\Http\Request;

class VideoGameService
{
    public function createFromRequest(Request $request, $check = true): VideoGame
    {
        if ($check && $this->exists($request->label)) {
            throw new \Exception(__('That video game already exists.'));
        }

        return VideoGame::create($request->merge([
            'date_released' => $request->date_released ?? DateService::today(),
        ])->all());
    }

    public function exists(string $label): bool
    {
        return VideoGame::where('label', $label)->exists();
    }

    public function createPsnFromRequest(Request $request, $check = true): VideoGame
    {
        if ($check && $this->exists($request->label)) {
            throw new \Exception(__('That video game already exists.'));
        }

        return VideoGame::create($request->merge([
            'date_released' => $request->date_released ?? DateService::today(),
        ])->all());
    }
}