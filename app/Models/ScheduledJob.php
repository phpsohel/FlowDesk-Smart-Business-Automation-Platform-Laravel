<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledJob extends Model
{
   use HasFactory;

    protected $fillable = [
        'name',
        'job_type',
        'frequency',
        'next_run_at',
        'last_run_at',
        'status',
        'description',
    ];
}
