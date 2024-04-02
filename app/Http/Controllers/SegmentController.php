<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Segment;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($event, $segment)
    {
        $event = Event::findOrFail($event);
        $segment = Segment::findOrFail($segment);

        return view('admin.events.segments.index', compact('event', 'segment'));
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
    public function store_criteria(Request $request, Event $event, Segment $segment)
    {
        $validated = $request->validate([
            'criteria_name' => 'required|regex:/^[A-Za-z\s]+$/|unique:criterias,criteria_name,NULL,id,event_id,' . $request->event_id . ',segment_id,' . $request->segment_id,
            'percentage' => 'required|numeric|between:0,100',
            'event_id' => 'required|exists:events,id',
            'segment_id' => 'required|exists:segments,id',
        ], [
            'criteria_name.unique' => 'The criteria name must be unique within the context of the selected event and segment.',
        ]);



        $event = Event::find($validated['event_id']);
        $segment = Segment::find($validated['segment_id']);

        $existingPercentagesSum = $segment->criterias->sum('percentage');

        $newPercentage = $validated['percentage'];

        if ($existingPercentagesSum + $newPercentage > 100) {
            return redirect()->route('events.segments.index', ['event' => $event, 'segment' => $segment])
                ->with('error', 'Total criteria percentage cannot exceed 100% for this segment');
        }

        $segment->criterias()->create($validated);

        return redirect()->route('events.segments.index', ['event' => $event, 'segment' => $segment])
            ->with('message', 'Criteria created successfully for the segment!');
    }


    public function criteria_update(Request $request, Event $event, Segment $segment, Criteria $criteria)
    {
        $validated = $request->validate([
            'criteria_name' => [
                'required',
                'regex:/^[A-Za-z\s]+$/',
                Rule::unique('criterias', 'criteria_name')->ignore($criteria->id)->where(function ($query) use ($request) {
                    return $query->where('event_id', $request->event_id);
                }),
            ],
            'percentage' => 'required|numeric|between:0,100',
            'event_id' => 'required|exists:events,id',
            'segment_id' => 'required|exists:segments,id',
        ]);

        $event = Event::find($validated['event_id']);
        $segment = Segment::find($validated['segment_id']);

        $existingPercentagesSum = $segment->criterias->sum('percentage');

        $newPercentage = $validated['percentage'];

        if ($existingPercentagesSum + $newPercentage > 100) {
            return redirect()->route('events.segments.index', ['event' => $event, 'segment' => $segment])
                ->with('error', 'Total criteria percentage cannot exceed 100% for this segment');
        }

        $segment->criterias()->update($validated);

        return redirect()->route('events.segments.index', ['event' => $event, 'segment' => $segment])
            ->with('message', 'Criteria created successfully for the segment!');
    }

    public function destroy_criteria(Criteria $criteria)
    {
        $event = $criteria->event;
        $segment = $criteria->segment;
        $criteria->delete();

        return redirect()->route('events.segments.index', ['event' => $event, 'segment' => $segment])
            ->with('message', 'Criteria deleted successfully!');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'segment_name' => 'required|regex:/^[A-Za-z\s]+$/|unique:segments,segment_name,NULL,id,event_id,' . $request->event_id,
            'percentage' => 'required|numeric|between:0,100',
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::find($request->event_id);

        $existingPercentagesSum = $event->segments->sum('percentage');

        $newPercentage = $validated['percentage'];

        if ($existingPercentagesSum + $newPercentage > 100) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Total percentage cannot exceed 100%');
        }

        $segment = Segment::create($validated);

        return redirect()->route('events.show', $event->id)
            ->with('message', 'Segment created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Segment $segment)
    {
        //
    }

    public function update_segment(Request $request, Segment $segment)
    {
        if (!$segment) {
            return redirect()->back()->with('error', 'Segment not found.');
        }

        $validated = $request->validate([
            'segment_name' => [
                'required',
                'regex:/^[A-Za-z\s]+$/',
                Rule::unique('segments', 'segment_name')->ignore($segment->id)->where(function ($query) use ($request) {
                    return $query->where('event_id', $request->event_id);
                }),
            ],
            'percentage' => 'required|numeric|between:0,100',
            'status' => 'required|in:show,hide',
            'event_id' => 'required|exists:events,id',
        ]);

        $event = $segment->event;

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        $existingPercentagesSum = $event->segments->sum('percentage');
        $newPercentage = $validated['percentage'];

        if ($existingPercentagesSum - $segment->percentage + $newPercentage > 100) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Total percentage cannot exceed 100%');
        }

        $segment->update($validated);

        return redirect()->route('events.show', ['event' => $segment->event_id])
            ->with('message', 'Segment updated successfully!');
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Segment $segment)
    {
        //

        // return $segment->criterias()->get();

        $validated = $request->validate([
            'criteria_name' => 'required|array',
            'percentage' => 'required|array',
            'criteria_name.*' => 'sometimes|required_with:percentage.*',
            'percentage.*' => 'sometimes|required_with:criteria_name.*',
        ]);

        $filteredID = array_filter($request->criteria_id, function ($value) {
            return $value !== null;
        });

        $segment->criterias()->whereNotIn('id', $filteredID)->delete();

        foreach ($request->criteria_name as $key => $value) {
            if ($value == '' || $request->percentage[$key] == '') {
                continue;
            }
            $segment->criterias()->updateOrCreate(
                [
                    'id' => $request->criteria_id[$key],
                ],
                [
                    'event_id' => $segment->event->id,
                    'criteria_name' => $value,
                    'percentage' => $request->percentage[$key],
                ]
            );
        };

        return redirect()->route('events.show', ['event' => $segment->event->id])
            ->with('message', 'Segment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Segment $segment)
    {
        $segment->delete();

        return redirect()
            ->route('events.show', ['event' => $event->id])
            ->with('message', 'Segment deleted successfully!');
    }

    public function criterias(Segment $segment)
    {
        return $segment->criterias()->get(['id', 'criteria_name', 'percentage', 'event_id', 'segment_id']);
    }
}
