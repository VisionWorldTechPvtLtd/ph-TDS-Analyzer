<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class STP extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'serial_no',
        'manufacturer',
        'flow_limit',
        'imei_no',
        'mobile_no',
        'address',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }
    
    public function stpData()
    {
        return $this->hasMany(STP_Data::class, 'stp_id');
    }

}
