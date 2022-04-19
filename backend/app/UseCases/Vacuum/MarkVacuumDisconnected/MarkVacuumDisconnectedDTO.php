<?php

namespace App\UseCases\Vacuum\MarkVacuumDisconnected;

use App\Core\Request;

class MarkVacuumDisconnectedDTO extends Request
{
    public $vacuum_id;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
