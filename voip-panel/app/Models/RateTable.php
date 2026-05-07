<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'prefix',
        'country',
        'description',
        'rate_per_minute',
        'connection_fee',
        'minimum_seconds',
        'increment_seconds',
        'effective_date',
        'status',
    ];

    protected $casts = [
        'rate_per_minute' => 'decimal:6',
        'effective_date' => 'date',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function calculateCost(int $seconds): float
    {
        if ($seconds < $this->minimum_seconds) {
            $seconds = $this->minimum_seconds;
        }

        $incrementedSeconds = ceil($seconds / $this->increment_seconds) * $this->increment_seconds;
        $minutes = $incrementedSeconds / 60;
        
        return round(($minutes * $this->rate_per_minute) + $this->connection_fee, 4);
    }
}
