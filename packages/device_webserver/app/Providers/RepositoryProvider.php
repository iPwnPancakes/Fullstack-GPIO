<?php

namespace App\Providers;

use App\Repositories\Pins\VacuumBinaryPinRepository;
use App\Repositories\Pins\IPinRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IPinRepository::class, VacuumBinaryPinRepository::class);
    }
}
