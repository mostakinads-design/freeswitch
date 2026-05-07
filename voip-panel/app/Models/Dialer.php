<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dialer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'queue_id',
        'campaign_id',
        'ratio',
        'max_lines',
        'answer_timeout',
        'amd_enabled',
        'ai_enabled',
        'ai_mode',
        'status',
        'settings',
    ];

    protected $casts = [
        'ratio' => 'decimal:2',
        'amd_enabled' => 'boolean',
        'ai_enabled' => 'boolean',
        'settings' => 'array',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPredictive(): bool
    {
        return $this->type === 'predictive';
    }
}
