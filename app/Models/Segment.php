<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    public function criterias()
    {
        return $this->hasMany(Criteria::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
