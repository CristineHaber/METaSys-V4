<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\Event;
use App\Models\Finalist;
use App\Models\Score;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'auth.prevent']);
    }

    /**
     * Show the application dashboard.
     *
     * return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $events = Event::all();

        // $audit_trails = AuditTrail::all();

        $eventCount = Event::count();

        $usertype = Auth::user()->usertype;

        // return $segments;


        switch ($usertype) {
            case 'admin':
                return view('admin.index', compact('eventCount', 'events'));
            case 'judge':

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

                $doesAllJudgeScores = $countAllCriteriasToScore == $countJudgesFinishedScoring;

                #####################
                # for final
                #####################
                $candidateScores = [];
                foreach ($candidates as $key => $candidate) :
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
                    $candidateScores[] = [
                        'candidate_id' => $candidate->id,
                        'candidate_name' => $candidate->candidate_name,
                        'candidate_number' => $candidate->candidate_number,
                        'candidate_address' => $candidate->candidate_address,
                        'candidate_picture' => $candidate->candidate_picture,
                        'total_score' => $totalScores,
                    ];
                endforeach;

                usort($candidateScores, function ($a, $b) {
                    return $b['total_score'] > $a['total_score'];
                    // return $b['total_score'] <=> $a['total_score'];

                });

                $topThreeFinalist = $user->judge->event->finalists->first();
                list($topThree, $topCandidates) = $topThreeFinalist
                    ? [$topThreeFinalist->finalist_name, array_slice($candidateScores, 0, $topThreeFinalist->finalist_name)]
                    : ["No Top Finalists Found", []];

                return view('judge.index', compact('segments', 'candidates', 'doesAllJudgeScores', 'topCandidates', 'finalists'));
            default:
                abort(403, 'Unauthorized role.');
        }
    }
}
