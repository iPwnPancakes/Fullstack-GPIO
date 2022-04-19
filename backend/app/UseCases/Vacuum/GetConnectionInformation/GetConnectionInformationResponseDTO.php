<?php

namespace App\UseCases\Vacuum\GetConnectionInformation;

use App\Core\Response;
use Carbon\Carbon;

class GetConnectionInformationResponseDTO extends Response
{
    /** @var bool */
    public $connected;

    /** @var Carbon */
    public $last_communication_at;

    /** @var Carbon */
    public $last_communication_attempt_at;

    /** @var boolean */
    public $is_on;
}
