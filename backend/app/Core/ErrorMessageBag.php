<?php

namespace App\Core;

use Illuminate\Support\MessageBag;

class ErrorMessageBag extends MessageBag {
    public function __construct(array $messages = [])
    {
        parent::__construct($messages);
    }
}
