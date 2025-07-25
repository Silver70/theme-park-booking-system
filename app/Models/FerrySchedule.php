<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FerrySchedule extends Model
{
    protected $fillable = [
        'departure_time',
        'origin',
        'destination',
        'seats_available',
        'created_by',
        'cancelled_at'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ferryTickets()
    {
        return $this->hasMany(FerryTicket::class);
    }

    /**
     * Get the number of tickets issued for this schedule
     */
    public function getTicketsIssuedAttribute()
    {
        // Use loaded relationship if available, otherwise query database
        if ($this->relationLoaded('ferryTickets')) {
            return $this->ferryTickets->count();
        }
        return $this->ferryTickets()->count();
    }

    /**
     * Get the remaining capacity for this schedule
     */
    public function getRemainingCapacityAttribute()
    {
        return $this->seats_available - $this->tickets_issued;
    }

    /**
     * Check if this schedule is at full capacity
     */
    public function getIsFullAttribute()
    {
        return $this->remaining_capacity <= 0;
    }

    /**
     * Get capacity display string (e.g., "45/50")
     */
    public function getCapacityDisplayAttribute()
    {
        return $this->tickets_issued . '/' . $this->seats_available;
    }

    /**
     * Get the computed status of the ferry schedule
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->cancelled_at) {
                    return 'cancelled';
                }
                
                if ($this->departure_time->isPast()) {
                    return 'completed';
                }
                
                return 'scheduled';
            }
        );
    }
}
