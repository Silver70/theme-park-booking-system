<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'booking_status',
        'confirmed_at',
        'confirmed_by',
    ];

    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function ferryTickets()
    {
        return $this->hasMany(FerryTicket::class);
    }

    public function ferryTicketRequests()
    {
        return $this->hasMany(FerryTicketRequest::class);
    }

    /**
     * Get a formatted booking reference
     */
    public function getBookingReferenceAttribute()
    {
        return 'BK' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get a short booking reference
     */
    public function getShortReferenceAttribute()
    {
        return 'BK' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get booking status
     */
    public function getStatusAttribute()
    {
        $now = now();
        
        if ($this->check_in_date > $now) {
            return 'upcoming';
        } elseif ($this->check_out_date < $now) {
            return 'completed';
        } else {
            return 'active';
        }
    }

    /**
     * Get status display text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'upcoming':
                return 'Upcoming';
            case 'active':
                return 'Active';
            case 'completed':
                return 'Completed';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get status color class
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'upcoming':
                return 'text-blue-600 dark:text-blue-400';
            case 'active':
                return 'text-green-600 dark:text-green-400';
            case 'completed':
                return 'text-gray-600 dark:text-gray-400';
            default:
                return 'text-gray-600 dark:text-gray-400';
        }
    }

    /**
     * Get booking confirmation status display text
     */
    public function getBookingStatusTextAttribute()
    {
        switch ($this->booking_status) {
            case 'pending':
                return 'Pending Confirmation';
            case 'confirmed':
                return 'Confirmed';
            case 'cancelled':
                return 'Cancelled';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get booking status color class
     */
    public function getBookingStatusColorAttribute()
    {
        switch ($this->booking_status) {
            case 'pending':
                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200';
            case 'confirmed':
                return 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200';
            case 'cancelled':
                return 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-200';
            default:
                return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
        }
    }

    /**
     * Check if booking can be confirmed
     */
    public function canBeConfirmed()
    {
        return $this->booking_status === 'pending';
    }

    /**
     * Check if booking is confirmed
     */
    public function isConfirmed()
    {
        return $this->booking_status === 'confirmed';
    }

    /**
     * Check if booking is cancelled
     */
    public function isCancelled()
    {
        return $this->booking_status === 'cancelled';
    }

    /**
     * Check if user has pending ferry ticket requests for this booking
     */
    public function hasPendingFerryRequests()
    {
        return $this->ferryTicketRequests()->where('status', 'pending')->exists();
    }

    /**
     * Check if user has approved ferry ticket requests for this booking
     */
    public function hasApprovedFerryRequests()
    {
        return $this->ferryTicketRequests()->where('status', 'approved')->exists();
    }

    /**
     * Get the ferry ticket request status for display
     */
    public function getFerryRequestStatusAttribute()
    {
        if ($this->ferryTickets->count() > 0) {
            return 'has_tickets';
        } elseif ($this->hasPendingFerryRequests()) {
            return 'pending_request';
        } elseif ($this->hasApprovedFerryRequests()) {
            return 'approved_request';
        } else {
            return 'no_request';
        }
    }
}
