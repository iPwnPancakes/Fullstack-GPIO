<?php

namespace App\Core;

abstract class Request extends DTO
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);
    }
};
