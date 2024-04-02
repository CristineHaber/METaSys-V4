<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalCriteria extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function finalist()
    {
        return $this->belongsTo(Finalist::class);
    }

    public function final_score()
    {
        return $this->hasMany(FinalScore::class);
    }
}
