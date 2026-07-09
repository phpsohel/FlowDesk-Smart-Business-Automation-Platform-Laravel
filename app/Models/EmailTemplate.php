<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
   protected $fillable = [
        'name',
        'subject',
        'body',
        'type',
        'is_active',
    ];

    public function logs()
    {
        return $this->hasMany(EmailLog::class);
    }
}
