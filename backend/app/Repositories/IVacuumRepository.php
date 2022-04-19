<?php

namespace App\Repositories;

use App\Models\Vacuum;

interface IVacuumRepository
{
    public function exists($id): bool;
    public function existsWithPublicIP(string $public_ip): bool;
    public function getVacuumByVacuumID($id): Vacuum;
    public function getVacuumByPublicIP(string $public_ip): Vacuum;
    public function save(Vacuum $vacuum): int;
}
