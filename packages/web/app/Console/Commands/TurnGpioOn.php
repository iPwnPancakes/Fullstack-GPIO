<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TurnGpioOn extends Command
{
    protected $signature = 'gpio';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        exec('sudo vacuum 60 out');
    }
}
