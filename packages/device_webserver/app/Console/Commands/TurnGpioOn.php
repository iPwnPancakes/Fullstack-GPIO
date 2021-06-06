<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TurnGpioOn extends Command
{
    protected $signature = 'gpio:set {pin_number} {direction}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pin = $this->argument('pin_number');
        $direction = $this->argument('direction');

        exec("sudo vacuum $pin $direction");
    }
}
