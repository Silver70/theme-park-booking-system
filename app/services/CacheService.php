<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Room;
use App\Models\FerrySchedule;
use App\Models\Location;
use App\Models\DashboardImage;

class CacheService
{
    const CACHE_TTL = 300; // 5 minutes
    const DASHBOARD_CACHE_TTL = 900; // 15 minutes
    const STATS_CACHE_TTL = 600; // 10 minutes

    /**
     * Get available rooms with caching
     */
    public function getAvailableRooms(int $limit = 6)
    {
        return Cache::remember("available_rooms_{$limit}", self::CACHE_TTL, function () use ($limit) {
            return Room::where('is_available', true)->take($limit)->get();
        });
    }

    /**
     * Get active ferry schedules count with caching
     */
    public function getActiveFerrySchedulesCount()
    {
        return Cache::remember('active_ferry_schedules_count', self::CACHE_TTL, function () {
            return FerrySchedule::whereNull('cancelled_at')
                ->where('departure_time', '>', now())
                ->count();
        });
    }

    /**
     * Get active locations count with caching
     */
    public function getActiveLocationsCount()
    {
        return Cache::remember('active_locations_count', self::CACHE_TTL, function () {
            return Location::where('is_active', true)->count();
        });
    }

    /**
     * Get dashboard images with caching
     */
    public function getDashboardImages()
    {
        return Cache::remember('dashboard_images', self::DASHBOARD_CACHE_TTL, function () {
            return DashboardImage::where('is_active', true)
                ->orderBy('display_order')
                ->get()
                ->groupBy('display_position');
        });
    }

    /**
     * Get ferry schedules with ticket counts (cached)
     */
    public function getFerrySchedulesWithCounts($userId = null, $bookingDates = null)
    {
        $cacheKey = 'ferry_schedules_with_counts';
        if ($userId && $bookingDates) {
            $cacheKey .= "_{$userId}_{$bookingDates['start']}_{$bookingDates['end']}";
        }

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($bookingDates) {
            $query = FerrySchedule::withCount('ferryTickets')
                ->whereNull('cancelled_at')
                ->where('departure_time', '>', now());

            if ($bookingDates) {
                $query->whereBetween('departure_time', [$bookingDates['start'], $bookingDates['end']]);
            }

            return $query->orderBy('departure_time', 'asc')->get();
        });
    }

    /**
     * Clear related caches when data changes
     */
    public function clearFerryRelatedCaches()
    {
        Cache::forget('active_ferry_schedules_count');
        Cache::forget('ferry_schedules_with_counts');
        // Clear user-specific caches if needed
        $pattern = 'ferry_schedules_with_counts_*';
        $this->clearCachePattern($pattern);
    }

    /**
     * Clear room related caches
     */
    public function clearRoomRelatedCaches()
    {
        Cache::forget('available_rooms_6');
        $pattern = 'available_rooms_*';
        $this->clearCachePattern($pattern);
    }

    /**
     * Clear dashboard related caches
     */
    public function clearDashboardCaches()
    {
        Cache::forget('dashboard_images');
        Cache::forget('active_locations_count');
    }

    /**
     * Helper to clear cache patterns (implement based on cache driver)
     */
    private function clearCachePattern(string $pattern)
    {
        // Note: This is a simplified version. 
        // For Redis, you'd use Redis::keys() and Redis::del()
        // For other drivers, you might need different approaches
        
        // For now, we'll clear commonly used variations
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget(str_replace('*', $i, $pattern));
        }
    }
}
