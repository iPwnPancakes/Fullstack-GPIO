<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuum extends Model
{
    use HasFactory;

    protected $table = 'vacuum';

    public $timestamps = false;

    protected $casts = [
        'last_communication_at' => 'datetime',
        'connected' => 'boolean',
        'public_ip' => 'string',
        'port' => 'integer',
        'is_on' => 'boolean'
    ];

    protected $fillable = ['last_communication_at', 'public_ip', 'connected', 'port', 'is_on'];
}
