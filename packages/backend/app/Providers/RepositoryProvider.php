<?php

namespace App\Providers;

use App\Repositories\EloquentVacuumRepository;
use App\Repositories\IVacuumRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IVacuumRepository::class, EloquentVacuumRepository::class);
    }
}
