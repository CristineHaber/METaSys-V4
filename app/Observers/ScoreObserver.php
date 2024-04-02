<?php

namespace App\Observers;

use App\Models\Score;
use App\Models\AuditTrail;
use Illuminate\Support\Facades\Auth;

class ScoreObserver
{
    /**
     * Handle the Score "created" event.
     */
    public function created(Score $score): void
    {
        AuditTrail::create([
            'title' => 'Score created',
            'description' => json_encode($score),
            'model' => 'Score',
            'created_by_user' => Auth::user()->id,
        ]);
    }


    /**
     * Handle the Score "updated" event.
     */
    public function updated(Score $score): void
    {
        //
    }

    /**
     * Handle the Score "deleted" event.
     */
    public function deleted(Score $score): void
    {
        //
    }

    /**
     * Handle the Score "restored" event.
     */
    public function restored(Score $score): void
    {
        //
    }

    /**
     * Handle the Score "force deleted" event.
     */
    public function forceDeleted(Score $score): void
    {
        //
    }
}
