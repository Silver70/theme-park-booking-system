<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'is_available',
        'capacity',
    ];

    protected $casts = [
        'price' => 'float',
        'is_available' => 'boolean',
        'capacity' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Check if the room is currently available (no active bookings)
     */
    public function getIsCurrentlyAvailableAttribute()
    {
        return !$this->bookings()
            ->where('check_in_date', '<=', now())
            ->where('check_out_date', '>', now())
            ->exists();
    }

    /**
     * Scope to get available rooms efficiently
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope to get rooms without active bookings
     */
    public function scopeNotCurrentlyBooked($query)
    {
        return $query->whereNotExists(function ($subquery) {
            $subquery->select(\DB::raw(1))
                ->from('bookings')
                ->whereColumn('bookings.room_id', 'rooms.id')
                ->where('check_in_date', '<=', now())
                ->where('check_out_date', '>', now());
        });
    }

    /**
     * Get the current availability status
     */
    public function getAvailabilityStatusAttribute()
    {
        if ($this->is_available && $this->is_currently_available) {
            return 'Available';
        } elseif (!$this->is_available) {
            return 'Maintenance';
        } else {
            return 'Occupied';
        }
    }
        
}
