<?php

namespace App\Core;

use App\Core\Result;

abstract class UseCase
{
    /**
     * @param Request $request A general object that holds data of an unspecified shape
     *
     * @return Result Returns either a failed or successful Result
     */
    abstract function execute(Request $request): Result;
}
