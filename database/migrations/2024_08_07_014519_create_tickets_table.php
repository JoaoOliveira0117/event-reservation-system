<?php

use App\Enums\TicketStatus;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table
                ->foreignUuid('user_id')
                ->constrained(table: 'users', indexName: 'tickets_user_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignUuid('event_id')
                ->constrained(table: 'events', indexName: 'tickets_event_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->enum('status', array_map(fn($case) => $case->value, TicketStatus::cases()));
            $table->timestamps();
            $table->primary(['user_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
