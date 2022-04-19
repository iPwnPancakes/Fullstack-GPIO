<?php

namespace App\Providers;

use App\Repositories\MainServer\HttpMainServerRepository;
use App\Repositories\MainServer\IMainServerRepository;
use App\Repositories\Pins\InMemoryPinRepository;
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
        switch (env('GPIO_ENV')) {
            case 'beaglebone':
            {
                $this->app->bind(IPinRepository::class, VacuumBinaryPinRepository::class);
                break;
            }
            default:
            {
                $this->app->bind(IPinRepository::class, InMemoryPinRepository::class);
            }
        }

        $this->app->bind(IMainServerRepository::class, HttpMainServerRepository::class);
    }
}
