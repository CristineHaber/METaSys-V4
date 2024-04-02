<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{

    public function store(Request $request)
    {
        $custom_rule = Rule::unique('candidates', 'candidate_number')
            ->where(function ($query) use ($request) {
                return $query->where('event_id', $request->event_id)
                    ->where('type', $request->type); // Include the 'type' field in the uniqueness check
            });
    
        $validated = $request->validate([
            'candidate_picture' => 'required|image|mimes:jpeg,png,jpg,gif',
            'candidate_name' => 'required',
            'candidate_number' => ['required', 'string', 'max:255', $custom_rule],
            'candidate_address' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id',
            'type' => 'required|in:mr,ms',
        ]);
    
        $event = Event::findOrFail($request->event_id);
    
        if ($request->hasFile('candidate_picture')) {
            $validated['candidate_picture'] = $request->file('candidate_picture')->store('candidate_pictures', 'public');
        }
    
        Candidate::create($validated);
    
        return redirect()
            ->route('events.show', ['event' => $event->id])
            ->with('message', 'Candidate created successfully!');
    }
    

    public function update(Request $request, Candidate $candidate)
    {
        $custom_rule = Rule::unique('candidates', 'candidate_number')
            ->where(function ($query) use ($request) {
                return $query->where('event_id', $request->event_id)
                    ->where('type', $request->type); // Include the 'type' field in the uniqueness check
            });

        $validated = $request->validate([
            'candidate_name' => 'required',
            'candidate_number' => ['required', 'string', 'max:255', $custom_rule],
            'candidate_address' => 'required|string|max:255',
             'type' => 'required|in:mr,ms',
        ]);

        if ($request->hasFile('candidate_picture')) {
            $validated['candidate_picture'] = $request->file('candidate_picture')->store('candidate_pictures', 'public');
        }

        $candidate->update($validated);

        return redirect()
            ->route('events.show', ['event' => $candidate->event_id])
            ->with('message', 'Candidate updated successfully!');
    }

    public function destroy(Event $event, Candidate $candidate)
    {

        if ($candidate->candidate_picture && Storage::disk('public')->exists($candidate->candidate_picture)) {
            Storage::disk('public')->delete($candidate->candidate_picture);
        }

        $candidate->delete();

        return redirect()
            ->route('events.show', ['event' => $event->id])
            ->with('message', 'Candidate deleted successfully!');
    }
}
