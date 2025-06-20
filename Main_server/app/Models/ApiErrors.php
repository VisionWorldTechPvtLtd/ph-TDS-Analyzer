<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiErrors extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'error_message',
        'status',
    ];

}
