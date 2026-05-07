<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RingGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'strategy',
        'ring_timeout',
        'extensions',
        'destination_if_no_answer',
        'status',
    ];

    protected $casts = [
        'extensions' => 'array',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getExtensionListAttribute(): string
    {
        return implode(', ', $this->extensions ?? []);
    }
}
