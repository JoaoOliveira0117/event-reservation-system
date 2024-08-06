<?php

use App\Enums\EventStatus;
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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->dateTime('date');
            $table->string('location', 200);
            $table->float('price', 2);
            $table->integer('attendee_limit')->nullable();
            $table->enum('status', array_map(fn($case) => $case->value, EventStatus::cases()));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
