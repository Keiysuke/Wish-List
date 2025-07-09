<?php

namespace App\Services;

use App\Models\TravelJourney;
use App\Models\TravelStep;
use Illuminate\Http\Request;

class TravelJourneyService
{
    public function exists(string $label): bool
    {
        return TravelJourney::where('label', $label)->exists();
    }

    public function createFromRequest(Request $request): TravelJourney
    {
        if ($this->exists($request->label)) {
            throw new \Exception(__('You already created a journey with that name.'));
        }
        $travelJourney = TravelJourney::create($request->only(['label', 'user_id']));
        $stepsData = $this->extractStepsDataFromRequest($request, $travelJourney->id);
        foreach ($stepsData as $data) {
            TravelStep::create($data);
        }
        return $travelJourney;
    }

    public function updateFromRequest(Request $request, TravelJourney $travelJourney): TravelJourney
    {
        $travelJourney->update($request->only(['label', 'user_id']));
        $max = (int) $request->max_nb_travel_steps;
        for ($i = 0; $i < $max; $i++) {
            // Si la case de suppression est cochée, on supprime l'étape si elle existe
            if ($request->has('travel_step_delete_' . $i)) {
                $stepId = $request->input('travel_step_id_' . $i);
                if ($stepId && ($step = $travelJourney->travelSteps()->find($stepId))) {
                    $step->delete();
                }
                continue;
            }
            $data = [
                'travel_journey_id' => $travelJourney->id,
                'city_id' => $request->input("travel_step_city_id_$i"),
                'start_date' => $request->input("travel_step_start_date_$i"),
                'end_date' => $request->input("travel_step_end_date_$i"),
            ];
            $stepId = $request->input("travel_step_id_$i");
            if ($stepId && ($step = $travelJourney->travelSteps()->find($stepId))) {
                $step->update($data);
            } else {
                $travelJourney->travelSteps()->create($data);
            }
        }
        return $travelJourney;
    }

    /**
     * Extract travel steps data from the request.
     *
     * @param Request $request
     * @param int $travelJourneyId
     * @param bool $withId
     * @return array
     */
    protected function extractStepsDataFromRequest(Request $request, int $travelJourneyId, bool $withId = false): array
    {
        $steps = [];
        $max = (int) $request->max_nb_travel_steps;
        for ($i = 0; $i < $max; $i++) {
            $data = [
                'travel_journey_id' => $travelJourneyId,
                'city_id' => $request->input("travel_step_city_id_$i"),
                'start_date' => $request->input("travel_step_start_date_$i"),
                'end_date' => $request->input("travel_step_end_date_$i"),
            ];
            if ($withId) {
                $data['id'] = $request->input("travel_step_id_$i");
            }
            $steps[] = $data;
        }
        return $steps;
    }
}
