<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-user', function(User $currentUser, User $targetUser) {
            return $currentUser->id === $targetUser->id;
        });

        Gate::define('manage-event', function(User $currentUser, Event $targetEvent) {
            return $currentUser->id === $targetEvent->createdBy->id;
        });

        Gate::define('manage-ticket', function(User $currentUser, Ticket $targetTicket) {
            dd($currentUser, $targetTicket->user);
            return $currentUser->id === $targetTicket->user->id;
        });

        Route::model('event', Event::class);
    }
}
