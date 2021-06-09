<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuum extends Model
{
    use HasFactory;

    protected $casts = [
        'last_communication_at' => 'timestamp',
        'connected' => 'boolean',
        'public_ip' => 'string',
        'port' => 'integer'
    ];
}
