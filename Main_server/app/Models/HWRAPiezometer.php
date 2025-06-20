<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HWRAPiezometer extends Model
{
    use HasFactory;
      protected $table = 'hwrapiezometer';
    protected $fillable = [
        'b_id',
        'nocnumber',
        'userkey',
        'companyname',
        'piezostructurenumber',
        'latitude',
        'longitude',
        'vendorfirmsname',
    ];
    public function pump(){
        return $this->belongsTo(Pump::class, 'b_id');
    }
}
