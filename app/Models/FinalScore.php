<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalScore extends Model
{
    use HasFactory;

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function final_criteria()
    {
        return $this->belongsTo(FinalCriteria::class);
    }

    public function judge()
    {
        return $this->belongsTo(Judge::class);
    }
}
