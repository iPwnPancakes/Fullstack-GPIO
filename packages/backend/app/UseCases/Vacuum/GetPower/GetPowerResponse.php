<?php


namespace App\UseCases\Vacuum\GetPower;


use App\Core\DTO;

class GetPowerResponse extends DTO
{
    public $device_id;
    public $pin_power;
    public $last_communication_at;
    public $attempt_time;
}
