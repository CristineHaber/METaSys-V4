<?php

namespace App\Observers;

use App\Models\AuditTrail;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */


    public function created(Event $event): void
    {
        AuditTrail::create([
            'title' => 'Event created',
            'description' => json_encode($event),
            'model' => 'Event',
            'created_by_user' => Auth::user()->id,
        ]);
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event)
    {
        $changes = $event->getChanges();

        if (!empty($changes)) {
            // Log only if there are changes
            AuditTrail::create([
                'title' => 'Event updated',
                'description' => json_encode([
                    'old_values' => $event->getOriginal(),
                    'new_values' => $changes,
                ]),
                'model' => 'Event',
                'created_by_user' => Auth::user()->id,
            ]);
        }
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event)
    {
        AuditTrail::create([
            'title' => 'Event deleted',
            'description' => json_encode([
                'deleted_values' => $event->toArray(),
            ]),
            'model' => 'Event',
            'created_by_user' => Auth::user()->id,
        ]);
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }
}
