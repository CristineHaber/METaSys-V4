<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Score;
use App\Models\Segment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function ranking()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
        
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // name="criteria_names[{{ $segment->id }}][{{ $candidate->id }}][{{ $criteria->id }}]"

        $validated = $request->validate([
            'score' => 'array|required',
            'score.*' => 'required',
            'candidate_id' => 'array|required',
            'candidate_id.*' => 'required|exists:candidates,id',
            'criteria_id' => 'array|required',
            'criteria_id.*' => 'required|exists:criterias,id',
        ]);

        foreach ($validated['score'] as $key => $value) {
            Score::create([
                'score' => $value,
                'candidate_id' => $validated['candidate_id'][$key],
                'criteria_id' => $validated['criteria_id'][$key],
                'judge_id' => Auth::user()->judge->id,
            ]);
        }

        // $validated = array_merge(['judge_id' => Auth::user()->id], $validated);
        // return $validated;


        return redirect()->back()->with('message', 'Scores saved successfully!');
        // return view('admin.')

    }

    /**
     * Display the specified resource.
     */
    public function total(Event $event, Segment $segment)
    {   
        // Retrieve the judges associated with the event.
        $judges = $event->judges;
    
        return view('admin.events.results.total', compact('event', 'judges', 'segment'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Score $score)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Score $score)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Score $score)
    {
        //
    }
}
