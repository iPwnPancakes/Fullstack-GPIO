<?php

namespace App\Repositories\Pins\Proxies;

use App\Core\DTO;

class VacuumBinaryProxyResponseDTO extends DTO
{
    /** @var int */
    public $pin_number;

    /** @var bool */
    public $power;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
