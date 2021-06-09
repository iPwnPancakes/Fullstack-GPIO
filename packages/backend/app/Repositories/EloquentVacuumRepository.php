<?php

namespace App\Repositories;

use App\Models\Vacuum;
use Exception;

class EloquentVacuumRepository implements IVacuumRepository
{
    public function exists($id): bool
    {
        $vacuum = Vacuum::find($id);

        return (bool)$vacuum;
    }

    public function existsWithPublicIP(string $public_ip): bool
    {
        $vacuum = Vacuum::where('public_ip', $public_ip)->first();

        if (!$vacuum) {
            throw new Exception('Could not find Vacuum with public ip');
        }

        return (bool)$vacuum;
    }

    public function getVacuumByVacuumID($id): Vacuum
    {
        $vacuum = Vacuum::find($id);

        if (!$vacuum) {
            throw new Exception('Could not find Vacuum with public ip');
        }

        return $vacuum;
    }

    public function getVacuumByPublicIP(string $public_ip): Vacuum
    {
        $vacuum = Vacuum::where('public_ip', $public_ip)->first();

        if (!$vacuum) {
            throw new Exception('Could not find Vacuum with public ip');
        }

        return $vacuum;
    }

    public function save(Vacuum $vacuum): void
    {
        $vacuum->save();
    }
}
