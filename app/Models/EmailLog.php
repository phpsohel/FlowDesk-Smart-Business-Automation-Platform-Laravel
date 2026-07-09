<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
  protected $fillable = [
        'email_template_id',
        'to_email',
        'subject',
        'body',
        'status',
        'error_message',
        'sent_at',
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }
}
