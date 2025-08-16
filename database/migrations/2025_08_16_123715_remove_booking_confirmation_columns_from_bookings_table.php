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
            // Check if columns exist before dropping
            if (Schema::hasColumn('bookings', 'confirmed_by')) {
                // Try to drop foreign key if it exists
                try {
                    $table->dropForeign(['confirmed_by']);
                } catch (Exception $e) {
                    // Foreign key might not exist, continue
                }
            }
            
            // Drop columns if they exist
            if (Schema::hasColumn('bookings', 'booking_status')) {
                $table->dropColumn('booking_status');
            }
            if (Schema::hasColumn('bookings', 'confirmed_at')) {
                $table->dropColumn('confirmed_at');
            }
            if (Schema::hasColumn('bookings', 'confirmed_by')) {
                $table->dropColumn('confirmed_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('booking_status', ['pending', 'confirmed', 'cancelled'])->default('pending')->after('check_out_date');
            $table->timestamp('confirmed_at')->nullable()->after('booking_status');
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('confirmed_at');
            $table->foreign('confirmed_by')->references('id')->on('users')->onDelete('set null');
        });
    }
};