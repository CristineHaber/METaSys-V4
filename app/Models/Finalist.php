<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finalist extends Model
{
    use HasFactory;
    
    public function final_criterias()
    {
        return $this->hasMany(FinalCriteria::class);
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
