<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'extension',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function extension()
    {
        return $this->hasOne(Extension::class);
    }

    public function queues()
    {
        return $this->belongsToMany(Queue::class, 'queue_members')
            ->withPivot('level', 'position', 'status')
            ->withTimestamps();
    }

    public function cdrs()
    {
        return $this->hasMany(CDR::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'created_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
