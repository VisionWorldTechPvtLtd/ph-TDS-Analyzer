<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class STP_Data extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        $requestedYear = request('year', date('Y'));
        $this->table = 'stp_year_' . $requestedYear; // ✅ fix here
        parent::__construct($attributes);
    }

    protected $fillable = [
        'stp_id', 'cod', 'bod', 'toc', 'tss', 'ph', 'temperature', 'h', 'i', 'created_at', 'updated_at'
    ];

    public function stp()
    {
        return $this->belongsTo(STP::class);
    }
}

