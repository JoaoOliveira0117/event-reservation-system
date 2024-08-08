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
        Schema::table('events', function (Blueprint $table) {
            $table
                ->foreignUuid('user_id')
                ->constrained(table: 'users', indexName: 'events_user_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if(DB::getDriverName() !=='sqlite') {
                $table->dropIndex('events_user_id');
                $table->dropColumn('user_id');
            }
        });
    }
};
