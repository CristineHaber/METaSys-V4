<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function judge()
    {
        return $this->belongsTo(Judge::class);
    }
}
