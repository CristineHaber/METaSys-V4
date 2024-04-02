<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Segment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{

    public function index()
    {
        $sessions = DB::table('sessions')->where('user_id')->get();
        $events = Event::latest()->get();

        return view('admin.events.index', [
            'events' => $events,
            'sessions' => $sessions
        ]);
    }

    public function create()
    {
        return view('admin.events.details.create');
    }
    

    public function generateUserName($name)
    {
        $randomUsername = Str::lower(Str::random(4));
        if (User::where('username', '=', $randomUsername)->exists()) {
            return $this->generateUserName($name);
        }
        return $randomUsername;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_place' => 'required',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
            'num_judges' => 'required|integer|min:1',
            'num_candidates' => 'required|integer|min:1',
            'num_rounds' => 'required|integer|min:1',
            'event_logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            'event_banner' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ]);
    
        $validated['user_id'] = auth()->id();
    
        if ($request->hasFile('event_logo')) {
            $validated['event_logo'] = $request->file('event_logo')->store('storage/', 'public');
        }
    
        if ($request->hasFile('event_banner')) {
            $validated['event_banner'] = $request->file('event_banner')->store('storage/', 'public');
        }
    
        $event = Event::create($validated);
    
        for ($i = 1; $i <= $validated['num_judges']; $i++) {
            $first_name = $request->input('first_name' . $i);
            $last_name = $request->input('last_name' . $i);
    
            $username = $this->generateUserName($first_name);
    
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username,
                'password' => Hash::make($first_name),
                'usertype' => 'judge',
            ]);
    
            $event->judges()->create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'event_id' => $event->id,
                'user_id' => $user->id,
            ]);
        }
    
        for ($i = 1; $i <= $validated['num_candidates']; $i++) {
            $candidatePicture = $request->file('candidate_picture' . $i);
            $candidateName = $request->input('candidate_name' . $i);
            $candidateNumber = $request->input('candidate_number' . $i);
            $candidateType = $request->input('type' . $i);
            $candidateAddress = $request->input('candidate_address' . $i);
    
            $candidatePicturePath = null; // Initialize to null in case there's no picture
    
            if ($candidatePicture) {
                $candidatePicturePath = $candidatePicture->store('storage/', 'public');
            }
    
            $event->candidates()->create([
                'candidate_name' => $candidateName,
                'candidate_picture' => $candidatePicturePath,
                'candidate_number' => $candidateNumber,
                'type' => $candidateType,
                'candidate_address' => $candidateAddress,
            ]);
        }
    
        for ($i = 1; $i <= $validated['num_rounds']; $i++) {
            $segmentName = $request->input('segment_name' . $i);
            $segmentPercentage = $request->input('percentage' . $i);
    
            Segment::create([
                'event_id' => $event->id,
                'segment_name' => $segmentName,
                'percentage' => $segmentPercentage,
            ]);
        }
    
        return redirect()
            ->route('events.index')
            ->with('message', 'Event created successfully!');
    }
    

    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('admin.events.details.show', [
            'event' => $event,
        ]);
    }

    public function edit(Event $event)
    {
    }

    public function update(Request $request, Event $event)
    {

        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_place' => 'required|string|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'start_time.required' => 'Start time is required.',
            'end_time.required' => 'End time is required.',
            'end_time.after' => 'End time must be after the start time.',
        ]);

        $event->update($validated);

        return redirect()
            ->route('events.show', ['event' => $event->id])
            ->with('message', 'Event details updated successfully');
    }


    public function update_image(Request $request, Event $event)
    {
        $validated = $request->validate([
            'event_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'event_banner' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('event_logo')) {
            $validated['event_logo'] = $request->file('event_logo')->store('storage', 'public');
        } else {
            $validated['event_logo'] = $event->event_logo;
        }

        if ($request->hasFile('event_banner')) {
            $validated['event_banner'] = $request->file('event_banner')->store('storage', 'public');
        } else {
            $validated['event_banner'] = $event->event_banner;
        }

        $event->update($validated);

        return redirect()
            ->route('events.show', ['event' => $event->id])
            ->with('message', 'Event image updated successfully!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('message', 'Event deleted successfully!');
    }

    public function history()
    {
        return view('admin.events.archives.index', [
            'events' => Event::onlyTrashed()->latest()->paginate(5)
        ]);
    }

    public function restore($id)
    {
        $event = Event::withTrashed()->find($id);

        $event->restore();

        return redirect()
            ->route('events.archives.history')
            ->with('message', 'Event restored successfully!');
    }
}
