<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Finalist;
use App\Models\Result;
use App\Models\Segment;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event, Segment $segment)
    {
        $judges = $event->judges;

        return view('admin.events.results.index', compact('event', 'judges', 'segment'));
    }


    public function generatePDFMr(Event $event, Segment $segment)
    {
        $judges = $event->judges;

        $totalScores = [];

        foreach ($event->candidates->where('type', 'mr') as $candidate) {
            $totalScore = \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                $query->where('segment_id', $segment->id);
            })
                ->where('candidate_id', $candidate->id)
                ->sum('score') / $judges->count();

            $totalScore = number_format($totalScore, 2);

            $totalScores[] = [
                'candidate_id' => $candidate->id,
                'total_score' => $totalScore,
            ];
        }

        usort($totalScores, function ($a, $b) {
            return $b['total_score'] > $a['total_score'];
        });

        $rank = 1;

        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator('MetaSYS');
        $pdf->SetAuthor('JPCS - MetaSys');
        $pdf->SetTitle('MetaSys - Result');
        $pdf->SetSubject('MetaSys');
        $pdf->SetKeywords('Result, PDF');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $html = View::make('admin.events.results.pdf', compact('event', 'judges', 'segment', 'totalScores', 'rank'))->render();

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('metasys-result.pdf', 'I');
    }

    public function generatePDFMs(Event $event, Segment $segment)
    {
        $judges = $event->judges;

        $totalScores = [];

        foreach ($event->candidates->where('type', 'ms') as $candidate) {
            $totalScore = \App\Models\Score::whereHas('criteria', function ($query) use ($segment) {
                $query->where('segment_id', $segment->id);
            })
                ->where('candidate_id', $candidate->id)
                ->sum('score') / $judges->count();

            $totalScore = number_format($totalScore, 2);

            $totalScores[] = [
                'candidate_id' => $candidate->id,
                'total_score' => $totalScore,
            ];
        }

        usort($totalScores, function ($a, $b) {
            return $b['total_score'] > $a['total_score'];
        });

        $rank = 1;

        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator('MetaSYS');
        $pdf->SetAuthor('JPCS - MetaSys');
        $pdf->SetTitle('MetaSys - Result');
        $pdf->SetSubject('MetaSys');
        $pdf->SetKeywords('Result, PDF');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $html = View::make('admin.events.results.pdf', compact('event', 'judges', 'segment', 'totalScores', 'rank'))->render();

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('metasys-result.pdf', 'I');
    }

    public function generateFinalist(Event $event, Finalist $finalist)
    {

        //dd($finalist);

        $judges = $event->judges;

        $totalScores = [];

        foreach ($event->candidates as $candidate) {
            $totalScore = \App\Models\FinalScore::whereHas('final_criteria', function ($query) use ($finalist) {
                $query->where('finalist_id', $finalist->id);
            })
                ->where('candidate_id', $candidate->id)
                ->sum('final_score') / $judges->count();

            $totalScore = number_format($totalScore, 2);

            $totalScores[] = [
                'candidate_id' => $candidate->id,
                'total_score' => $totalScore,
            ];
        }

        usort($totalScores, function ($a, $b) {
            return $b['total_score'] > $a['total_score'];
        });

        $top_finalist = $finalist->finalist_name;

        $totalScores = collect($totalScores)
            ->sortByDesc('total_score')
            ->take($top_finalist);



        $rank = 1;

        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator('MetaSYS');
        $pdf->SetAuthor('JPCS - MetaSys');
        $pdf->SetTitle('MetaSys - Result');
        $pdf->SetSubject('MetaSys');
        $pdf->SetKeywords('Result, PDF');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $html = View::make('admin.events.results.finalist_pdf', compact('event', 'judges', 'finalist', 'totalScores', 'rank'))->render();

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('metasys-result-finalist.pdf', 'I');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function result_finalist(Event $event, Finalist $finalist)
    {
        $judges = $event->judges;

        return view('admin.events.results.final_result', compact('event', 'judges', 'finalist'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }
}
