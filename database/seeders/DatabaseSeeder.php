<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $mainUser = User::factory()->create([
            'email' => 'aurora@email.com',
            'password' => '_@@aurora2024'
        ]);

        User::factory(2)->create();
        Event::factory(3)->create();
        Ticket::factory(3)->create([
            'user_id' => $mainUser->id
        ]);
    }
}
