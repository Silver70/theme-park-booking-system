<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FerryTicket extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'ferry_schedule_id',
        'price',
    ];
    
    public function ferrySchedule()
    {
        return $this->belongsTo(FerrySchedule::class, 'ferry_schedule_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    
    
    
    
}
