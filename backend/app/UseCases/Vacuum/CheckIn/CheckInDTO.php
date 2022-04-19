<?php

namespace App\UseCases\Vacuum\CheckIn;

use App\Core\Request;

class CheckInDTO extends Request
{
    public $public_ip;
    public $port;
    public $pin_number;
    public $pin_state;
}
