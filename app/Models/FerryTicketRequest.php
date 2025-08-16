<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FerryTicketRequest extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'ferry_schedule_id',
        'quantity',
        'total_price',
        'status', // pending, approved, denied, cancelled
        'notes',
        'approved_by',
        'approved_at',
        'denied_at',
        'denial_reason',
    ];

    protected $casts = [
        'total_price' => 'float',
        'approved_at' => 'datetime',
        'denied_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DENIED = 'denied';
    const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function ferrySchedule()
    {
        return $this->belongsTo(FerrySchedule::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if request is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if request is approved
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if request is denied
     */
    public function isDenied()
    {
        return $this->status === self::STATUS_DENIED;
    }

    /**
     * Check if request is cancelled
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Get status display text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'Pending Review';
            case self::STATUS_APPROVED:
                return 'Approved';
            case self::STATUS_DENIED:
                return 'Denied';
            case self::STATUS_CANCELLED:
                return 'Cancelled';
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
            case self::STATUS_PENDING:
                return 'text-yellow-600 dark:text-yellow-400';
            case self::STATUS_APPROVED:
                return 'text-green-600 dark:text-green-400';
            case self::STATUS_DENIED:
                return 'text-red-600 dark:text-red-400';
            case self::STATUS_CANCELLED:
                return 'text-gray-600 dark:text-gray-400';
            default:
                return 'text-gray-600 dark:text-gray-400';
        }
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200';
            case self::STATUS_APPROVED:
                return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200';
            case self::STATUS_DENIED:
                return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200';
            case self::STATUS_CANCELLED:
                return 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200';
            default:
                return 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200';
        }
    }
}
