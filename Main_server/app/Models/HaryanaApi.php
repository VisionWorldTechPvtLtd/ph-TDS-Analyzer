<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaryanaApi extends Model
{
    use HasFactory;
    protected $table = 'haryanaapi';
    protected $fillable = [
        'b_id',
        'nocnumber',
        'userkey',
        'companyname',
        'abstructionstructurenumber',
        'latitude',
        'longitude',
        'vendorfirmsname',
    ];
    public function pump(){
        return $this->belongsTo(Pump::class, 'b_id');
    }


}