<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\FinalCriteria;
use App\Models\Finalist;
use App\Models\Segment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;


class FinalistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        //
        // dd($event);
        $candidates = $event->candidates;
        $segments = $event->segments;
        // ;$even ts = Event::findOrfail();
        // dd($events->candidates);
        return view('admin.events.finalist.index', compact('candidates', 'segments', 'event'));
    }


    public function finalist_segment(Request $request)
    {
        $validated = $request->validate([
            'final_criteria_name' => 'required',
            'percentage' => 'required',
            'event_id' => 'required|exists:events,id',
            'finalist_id' => 'required|exists:finalists,id',
        ]);

        $event = Event::find($validated['event_id']);
        $finalist = Finalist::find($validated['finalist_id']);

        $existingPercentagesSum = $finalist->final_criterias->sum('percentage');

        $newPercentage = $validated['percentage'];

        if ($existingPercentagesSum + $newPercentage > 100) {
            return redirect()->route('events.finalist.index', ['event' => $event, 'finalist' => $finalist])
                ->with('error', 'Total criteria percentage cannot exceed 100% for this finalist');
        }

        $finalist->final_criterias()->create($validated);

        return redirect()->route('events.finalist.index', ['event' => $event, 'finalist' => $finalist])
            ->with('message', 'Criteria created successfully for the finalist!');
    }

    public function finalist_index($event, $finalist)
    {
        $event = Event::find($event);
        $finalist = Finalist::find($finalist);

        return view('admin.events.finalist.index2', compact('event', 'finalist'));
    }

    public function update_finalist(Request $request, Finalist $finalist)
    {
        if (!$finalist) {
            return redirect()->back()->with('error', 'Finalist not found.');
        }

        $validated = $request->validate([
            'finalist_name' => [
                'required',
                Rule::unique('finalists', 'finalist_name')->ignore($finalist->id)->where(function ($query) use ($request) {
                    return $query->where('event_id', $request->event_id);
                }),
            ],
            'percentage' => 'required|numeric|between:0,100',
            'status' => 'required|in:show,hide',
            'event_id' => 'required|exists:events,id',
        ]);

        $event = $finalist->event;

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        $existingPercentagesSum = $event->finalists->sum('percentage');
        $newPercentage = $validated['percentage'];

        if ($existingPercentagesSum - $finalist->percentage + $newPercentage > 100) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Total percentage cannot exceed 100%');
        }

        $finalist->update($validated);

        return redirect()->route('events.show', ['event' => $finalist->event_id])
            ->with('message', 'Finalist updated successfully!');
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
            'finalist_name' => 'required',
            'percentage' => 'required|max:255',
            'event_id' => 'required|exists:events,id',
        ]);

        #dd($validated['finalist_name']);

        $event = Event::find($request->event_id);

        $existingPercentagesSum = $event->finalists->sum('percentage');

        $newPercentage = $validated['percentage'];

        if ($existingPercentagesSum + $newPercentage > 100) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Total percentage cannot exceed 100%');
        }

        Finalist::create($validated);

        return redirect()->route('events.show', $event->id)
            ->with('message', 'Finalist created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Finalist $finalist)
    {
        return view('admin.finalist.index', compact('event', 'finalist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finalist $finalist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finalist $finalist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Finalist $finalist)
    {
        $finalist->delete();

        return redirect()
            ->route('events.show', ['event' => $event->id])
            ->with('message', 'Finalist deleted successfully!');
    }

    public function destroy_finalist_criteria(FinalCriteria $final_criteria)
    {

        $event = $final_criteria->event;
        $finalist = $final_criteria->finalist;
        $final_criteria->delete();

        return redirect()->route('events.finalist.index', ['event' => $event, 'finalist' => $finalist])
            ->with('message', 'Criteria deleted successfully!');
    }

    public function generateResult(Event $event, Segment $segment)
    {
        $judges = $event->judges;
        $segments = $event->segments;
        
        // Fetch the candidates for the event, adjust the query as needed
        $candidates = $event->candidates->where('type', 'mr');
    
        foreach ($segments as $segment) {
            $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    
            $pdf->SetCreator('MetaSYS');
            $pdf->SetAuthor('JPCS - MetaSys');
            $pdf->SetTitle('MetaSys - Result');
            $pdf->SetSubject('MetaSys');
            $pdf->SetKeywords('Result, PDF');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();
    
            // Pass both $event, $judges, $segment, and $candidates to the view
            $html = View::make('admin.events.finalist.generate-result', compact('event', 'judges', 'segment', 'segments', 'candidates'))->render();
    
            $pdf->writeHTML($html, true, false, true, false, '');
    
            $pdf->Output('metasys-result-' . $segment->id . '.pdf', 'I');
        }
    }
    
    public function generateResult1(Event $event, Segment $segment)
    {
        $judges = $event->judges;
        $segments = $event->segments;
        
        // Fetch the candidates for the event, adjust the query as needed
        $candidates = $event->candidates->where('type', 'ms');
    
        foreach ($segments as $segment) {
            $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    
            $pdf->SetCreator('MetaSYS');
            $pdf->SetAuthor('JPCS - MetaSys');
            $pdf->SetTitle('MetaSys - Result');
            $pdf->SetSubject('MetaSys');
            $pdf->SetKeywords('Result, PDF');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();
    
            // Pass both $event, $judges, $segment, and $candidates to the view
            $html = View::make('admin.events.finalist.generate-result1', compact('event', 'judges', 'segment', 'segments', 'candidates'))->render();
    
            $pdf->writeHTML($html, true, false, true, false, '');
    
            $pdf->Output('metasys-result-' . $segment->id . '.pdf', 'I');
        }
    }
}
