<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimModel extends Model
{
    use HasFactory;
    protected $table = 'sims';
    protected $dates = ['sim_start', 'sim_end'];
    protected $fillable = [
        'sim_company',
        'sim_imei',
        'sim_number',
        'sim_name',
        'sim_type',
        'sim_active',
        'sim_purchase',
        'sim_start',
        'pump_id',
        'sim_end',
        'id'

    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function pump(){
        return $this->belongsTo(Pump::class,'id');
    }

}
