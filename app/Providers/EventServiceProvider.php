<?php

namespace App\Providers;

use App\Events\RecordDespenseMedicine;
use App\Listeners\GenerateDespenseMedsReciept;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        'Illuminate\Auth\Events\Login' => [
            // 'App\Listeners\LogSuccessfulLogin',
            'App\Listeners\UserHasLogin',
        ],
     
        'Illuminate\Auth\Events\Logout' => [
            // 'App\Listeners\LogSuccessfulLogout',
            'App\Listeners\UserHasLogout',
        ],

        // event for when user despense medicine
        RecordDespenseMedicine::class => [
            GenerateDespenseMedsReciept::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
