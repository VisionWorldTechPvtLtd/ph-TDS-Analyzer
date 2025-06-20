<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pump extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pump_title',
        'serial_no',
        'last_calibration_date',
        'pipe_size',
        'manufacturer',
        'flow_limit',
        'imei_no',
        'mobile_no',
        'address',
    ];
    protected $dates = [
        'plan_start_date',
        'plan_end_date',

    ];


    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    // public function pumpData() {
    //     return $this->hasOne(PumpData::class);
    // }
    public function pumpData() {
        return $this->hasMany(PumpData::class);
    }
    public function sim() {
        return $this->belongsTo(SimModel::class, 'pump_id');
    }

}
