<?php

namespace App\Providers;

use App\Events\VacuumTimedOut;
use App\Listeners\MarkVacuumDisconnected;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        VacuumTimedOut::class => MarkVacuumDisconnected::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
