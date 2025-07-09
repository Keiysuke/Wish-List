<?php
namespace App\Http\Controllers;

use App\Http\Requests\TravelJourneyRequest;
use App\Models\TravelJourney;
use App\Models\TravelStep;
use App\Services\TravelJourneyService;
use Illuminate\Support\Facades\Auth;

class TravelJourneyController extends Controller
{
    public function getSteps(int $userId, int $nb){
        $html = view('partials.travel_journeys.select_travel_step', compact('nb'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function getStepProducts(int $userId, int $stepNb, int $nb){
        $html = view('partials.travel_journeys.form.select_product', compact('nb', 'stepNb'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function index()
    {
        $journeys = TravelJourney::with('travelSteps.city')->where('user_id', Auth::id())->get();
        return view('travel_journeys.index', compact('journeys'));
    }

    public function show(TravelJourney $travelJourney)
    {
        $travelJourney->load('travelSteps.city');
        
        $info = __('The journey has been created.');
        return view('travel_journeys.show', compact('travelJourney'))->with('info', $info);
    }

    public function create()
    {
        return view('travel_journeys.create');
    }

    public function store(TravelJourneyRequest $request)
    {
        try {
            $travelJourney = (new TravelJourneyService())->createFromRequest($request);
            return redirect()->route('travel_journeys.show', $travelJourney)->with('info', 'Voyage créé avec succès !');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Erreur lors de la création du voyage : ' . $e->getMessage()]);
        }
    }

    public function edit(TravelJourney $travelJourney){
        return view('travel_journeys.edit', compact('travelJourney'));
    }

    public function update(TravelJourneyRequest $request, TravelJourney $travelJourney)
    {
        try {
            $travelJourney = (new TravelJourneyService())->updateFromRequest($request, $travelJourney);
            return redirect()->route('travel_journeys.show', $travelJourney)->with('info', 'Voyage édité avec succès !');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Erreur lors de l\'édition du voyage : ' . $e->getMessage()]);
        }
    }
}
