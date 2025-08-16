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
        // Drop event_tickets first due to foreign key constraint
        Schema::dropIfExists('event_tickets');
        
        // Then drop events table
        Schema::dropIfExists('events');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate events table first
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['ride', 'show', 'beach_event']);
            $table->string('location');
            $table->timestamps();
        });

        // Then recreate event_tickets table
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events');
            $table->float('price');
            $table->timestamps();
        });
    }
};