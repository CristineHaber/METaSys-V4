<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public function judges()
    {
        return $this->hasMany(Judge::class);
    }
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
    public function segments()
    {
        return $this->hasMany(Segment::class);
    }

    public function finalists()
    {
        return $this->hasMany(Finalist::class);
    }

    public function criterias()
    {
        return $this->hasMany(Criteria::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
