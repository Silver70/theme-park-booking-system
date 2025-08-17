<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Frequently queried columns for active bookings
            $table->index(['user_id', 'check_out_date']);
            $table->index(['check_in_date', 'check_out_date']);
            $table->index('check_out_date');
        });

        Schema::table('ferry_schedules', function (Blueprint $table) {
            // Frequently queried for active schedules
            $table->index(['departure_time', 'cancelled_at']);
            $table->index('cancelled_at');
        });

        Schema::table('ferry_tickets', function (Blueprint $table) {
            // For counting tickets per schedule
            $table->index(['ferry_schedule_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('is_used');
        });

        Schema::table('rooms', function (Blueprint $table) {
            // For available room queries
            $table->index('is_available');
        });

        Schema::table('dashboard_images', function (Blueprint $table) {
            // For dashboard image queries
            $table->index(['is_active', 'display_position', 'display_order']);
        });

        Schema::table('locations', function (Blueprint $table) {
            // For active location queries
            $table->index(['is_active', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'check_out_date']);
            $table->dropIndex(['check_in_date', 'check_out_date']);
            $table->dropIndex(['check_out_date']);
        });

        Schema::table('ferry_schedules', function (Blueprint $table) {
            $table->dropIndex(['departure_time', 'cancelled_at']);
            $table->dropIndex(['cancelled_at']);
        });

        Schema::table('ferry_tickets', function (Blueprint $table) {
            $table->dropIndex(['ferry_schedule_id', 'created_at']);
            $table->dropIndex(['user_id', 'created_at']);
            $table->dropIndex(['is_used']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex(['is_available']);
        });

        Schema::table('dashboard_images', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'display_position', 'display_order']);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'display_order']);
        });
    }
};
