<?php

namespace App\Core;

abstract class Response extends DTO
{
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);
    }
};
