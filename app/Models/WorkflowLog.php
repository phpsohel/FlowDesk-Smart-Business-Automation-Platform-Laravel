<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'status',
        'message',
        'executed_at',
    ];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }
}
