<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use App\Models\JudgeDashboard;
use Illuminate\Support\Facades\Auth;

class JudgeDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'auth.prevent']);
    }
    
    public function index()
    {
        //
        $user = Auth::user();
        $segments = $user->judge->event->segments;
        $finalists = $user->judge->event->finalists;

        $candidates = $user->judge->event->candidates;



        // $countJudgesFinishedScoring = $user->judge->event->judges()
        //     ->whereHas('scores', function ($query) use ($candidates) {
        //         $query->select('judge_id')  // Select the necessary columns for the subquery
        //             ->groupBy('judge_id')
        //             ->havingRaw('COUNT(DISTINCT candidate_id) = ?', [$candidates->count()]);
        //     })->count();


        $countJudgesFinishedScoring = Score::whereHas('criteria', function ($query) use ($user) {
            $query->whereHas('event', function ($query) use ($user) {
                $query->where('id',  $user->judge->event->id);
            });
        })->count();


        //dd($countJudgesFinishedScoring);


        $countAllEventJudge = $user->judge->event->judges()->count();
        $countAllEventCriterials = $user->judge->event->criterias()->count();
        $countAllCriteriasToScore = $countAllEventJudge * $countAllEventCriterials * $candidates->count();

        // return [
        //     'countJudgesFinishedScoring' => $countJudgesFinishedScoring,
        //     'countAllEventJudge' => $countAllEventJudge,
        //     'countAllEventCriterials' => $countAllEventCriterials,
        //     'countAllCriteriasToScore' => $countAllCriteriasToScore,
        // ];

        $doesAllJudgeScores = $segments->count() && $countAllCriteriasToScore == $countJudgesFinishedScoring;

        #####################
        # for final
        #####################
        $candidateScoresMr = [];
        foreach ($candidates->where('type', 'mr') as $key => $candidate) :
            $totalScores = 0;
            foreach ($segments as $segment) :
                $score =
                    \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                        $query->where('segment_id', $segment->id);
                    })
                    ->where('candidate_id', $candidate->id)
                    ->sum('score') / $countAllEventJudge;

                $score = number_format($score * ($segment->percentage / 100), 2);
                $totalScores += $score;
            endforeach;
            $candidateScoresMr[] = [
                'candidate_id' => $candidate->id,
                'candidate_name' => $candidate->candidate_name,
                'candidate_number' => $candidate->candidate_number,
                'candidate_address' => $candidate->candidate_address,
                'candidate_picture' => $candidate->candidate_picture,
                'type' => $candidate->type,
                'total_score' => $totalScores,
            ];
        endforeach;

        usort($candidateScoresMr, function ($a, $b) {
            return $b['total_score'] > $a['total_score'];
            // return $b['total_score'] <=> $a['total_score'];

        });

        $candidateScoresMs = [];
        foreach ($candidates->where('type', 'ms') as $key => $candidate) :
            $totalScores = 0;
            foreach ($segments as $segment) :
                $score =
                    \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                        $query->where('segment_id', $segment->id);
                    })
                    ->where('candidate_id', $candidate->id)
                    ->sum('score') / $countAllEventJudge;

                $score = number_format($score * ($segment->percentage / 100), 2);
                $totalScores += $score;
            endforeach;
            $candidateScoresMs[] = [
                'candidate_id' => $candidate->id,
                'candidate_name' => $candidate->candidate_name,
                'candidate_number' => $candidate->candidate_number,
                'candidate_address' => $candidate->candidate_address,
                'candidate_picture' => $candidate->candidate_picture,
                'type' => $candidate->type,
                'total_score' => $totalScores,
            ];
        endforeach;

        usort($candidateScoresMs, function ($a, $b) {
            return $b['total_score'] > $a['total_score'];
            // return $b['total_score'] <=> $a['total_score'];

        });

        
        $topThreeFinalist = $user->judge->event->finalists->first();

        list($topThree, $topCandidatesMr) = $topThreeFinalist
            ? [$topThreeFinalist->finalist_name, array_slice($candidateScoresMr, 0, $topThreeFinalist->finalist_name)]
            : ["No Top Finalists Found", []];

        list($topThree, $topCandidatesMs) = $topThreeFinalist
            ? [$topThreeFinalist->finalist_name, array_slice($candidateScoresMs, 0, $topThreeFinalist->finalist_name)]
            : ["No Top Finalists Found", []];
        
        return view('judge.index', compact('segments', 'candidates', 'doesAllJudgeScores', 'topCandidatesMr', 'topCandidatesMs', 'finalists'));
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
        //
        return $request;

        // Update the database with the scores
        // ...

        // Send a response back to the client
        return redirect()->back()->with('success', 'Scores saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(JudgeDashboard $judgeDashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JudgeDashboard $judgeDashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JudgeDashboard $judgeDashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JudgeDashboard $judgeDashboard)
    {
        //
    }
}
