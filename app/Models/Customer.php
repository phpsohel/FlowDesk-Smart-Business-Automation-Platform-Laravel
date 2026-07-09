<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'status',
        'address',
        'notes',
    ];
    public function invoices()
{
    return $this->hasMany(Invoice::class);
}
public function payments()
{
    return $this->hasMany(Payment::class);
}
}
