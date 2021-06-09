<?php

namespace App\Providers;

use App\Repositories\GpioPins\IGpioPinRepository;
use App\Repositories\GpioPins\VacuumBinaryPinRepository;
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
        $this->app->bind(IGpioPinRepository::class, VacuumBinaryPinRepository::class);
    }
}
