<?php

namespace App\UseCases\Vacuum\GetConnectionInformation;

use App\Core\Request;

class GetConnectionInformationDTO extends Request
{
    public $vacuum_id;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
