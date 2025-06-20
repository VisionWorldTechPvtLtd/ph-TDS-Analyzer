<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PumpDailyFlowData extends Model
{
    use HasFactory;
    
    public function __construct(array $attributes = [])
    {
        $requestedYear = request('year', date('Y'));  
        $this->table = 'year_' . $requestedYear;  
        parent::__construct($attributes);
    }

    public function pump()
    {
        return $this->belongsTo(Pump::class);
    }
    
}