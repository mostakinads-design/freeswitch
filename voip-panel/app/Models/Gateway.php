<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'password',
        'realm',
        'proxy',
        'register_proxy',
        'expire_seconds',
        'register',
        'transport',
        'status',
        'settings',
    ];

    protected $casts = [
        'register' => 'boolean',
        'settings' => 'array',
    ];

    public function dids()
    {
        return $this->hasMany(DID::class);
    }

    public function cdrs()
    {
        return $this->hasMany(CDR::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
