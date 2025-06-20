<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class STP_Data extends Model
{
    use HasFactory;
    protected $fillable = ['stp_id', 'cod', 'bod', 'toc', 'tss', 'ph', 'temperature', 'h', 'i'];
    
    public function stps()
    {
        return $this->hasMany(STP_Data::class, 'stp_id');
    }
}
