<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
