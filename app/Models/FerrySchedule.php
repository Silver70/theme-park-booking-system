<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FerrySchedule extends Model
{
    protected $fillable = [
        'departure_time',
        'origin',
        'destination',
        'seats_available',
        'created_by'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
