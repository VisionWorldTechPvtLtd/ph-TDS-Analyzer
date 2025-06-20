<?php

namespace App\Models;

use App\Http\Requests\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PumpData extends Model
{
    use HasFactory;

    public function pump(){
        return $this->belongsTo(Pump::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
