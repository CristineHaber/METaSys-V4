<?php

namespace App\Http\Controllers;

use App\Models\FinalScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinalScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        // return $request;
        $validated = $request->validate([
            'final_score' => 'array|required',
            'final_score.*' => 'required',
            'candidate_id' => 'array|required',
            'candidate_id.*' => 'required|exists:candidates,id',
            'final_criteria_id' => 'array|required',
            'final_criteria_id.*' => 'required|exists:final_criterias,id',
        ]);

        foreach ($validated['final_score'] as $key => $value) {
            FinalScore::create([
                'final_score' => $value,
                'candidate_id' => $validated['candidate_id'][$key],
                'final_criteria_id' => $validated['final_criteria_id'][$key],
                'judge_id' => Auth::user()->judge->id,
            ]);
        }

        // $validated = array_merge(['judge_id' => Auth::user()->id], $validated);
        // return $validated;


        return redirect()->back()->with('message', 'Scores saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinalScore $finalScore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinalScore $finalScore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinalScore $finalScore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinalScore $finalScore)
    {
        //
    }
}
