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
            $table->enum('booking_status', ['pending', 'confirmed', 'cancelled'])->default('pending')->after('check_out_date');
            $table->timestamp('confirmed_at')->nullable()->after('booking_status');
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('confirmed_at');
            $table->foreign('confirmed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn(['booking_status', 'confirmed_at', 'confirmed_by']);
        });
    }
};
