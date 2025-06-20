<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PumpHistoryData extends Model
{
    use HasFactory;

    public function pump(){
        return $this->belongsTo(Pump::class);
    } 
    
}
