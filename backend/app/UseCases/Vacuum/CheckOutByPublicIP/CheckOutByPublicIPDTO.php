<?php

namespace App\UseCases\Vacuum\CheckOutByPublicIP;

use App\Core\Request;

class CheckOutByPublicIPDTO extends Request
{
    public $public_ip;
}
