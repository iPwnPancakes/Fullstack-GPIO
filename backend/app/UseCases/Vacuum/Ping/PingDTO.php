<?php

namespace App\UseCases\Vacuum\Ping;

use App\Core\Request;

class PingDTO extends Request
{
    public $vacuum_id;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
