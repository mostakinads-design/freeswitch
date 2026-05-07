<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DID extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dids';

    protected $fillable = [
        'number',
        'country_code',
        'destination_type',
        'destination_value',
        'gateway_id',
        'description',
        'status',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'caller_id_did_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getFormattedNumberAttribute(): string
    {
        return "+{$this->country_code}{$this->number}";
    }
}
