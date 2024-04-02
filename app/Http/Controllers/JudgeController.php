<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Judge;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JudgeController extends Controller
{

    public function index()
    {
        // $events = Event::all();
        // return view('judge.index');
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
        $request->validate([
            'first_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'last_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'is_chairman' => 'required|in:0,1',
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::find($request->event_id);

        if ($request->is_chairman == 0 && $event->judges()->where('is_chairman', 0)->count() > 0) {
            return redirect()->back()
                ->with('error', 'There is already a chairman for this event.');
        }

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $is_chairman = $request->is_chairman;

        $username = $this->generateUserName($first_name);

        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'username' => $username,
            'password' => Hash::make($first_name),
            'usertype' => 'judge',
        ]);

        $judges = $event->judges()->create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'is_chairman' => $is_chairman,
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('events.show', $event->id)
            ->with('message', 'Judge created successfully!');
    }

    public function update(Request $request, Judge $judge)
    {
        $request->validate([
            'first_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'last_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'is_chairman' => 'required|boolean',
        ]);

        $event = Event::find($request->event_id);

        if ($request->is_chairman == 0 && $event->judges()->where('is_chairman', 0)->count() > 0) {
            return redirect()->back()
                ->with('error', 'There is already a chairman for this event.');
        }

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $is_chairman = $request->is_chairman;

        $judge->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'is_chairman' => $is_chairman,
        ]);

        $user = $judge->user;

        $user->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'password' => Hash::make($first_name),
        ]);

        return redirect()->route('events.show', $judge->event->id)
            ->with('message', 'Judge updated successfully!');
    }

    public function destroy(Judge $judge, Request $request)
    {
        $eventId = $judge->event_id;

        $judge->delete();

        return redirect()->route('events.show', ['event' => $eventId])
            ->with('message', 'Judge deleted successfully!');
    }
}
