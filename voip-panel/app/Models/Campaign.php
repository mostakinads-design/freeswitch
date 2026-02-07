<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'message',
        'audio_file',
        'caller_id_did_id',
        'scheduled_at',
        'status',
        'total_contacts',
        'completed_contacts',
        'failed_contacts',
        'settings',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'settings' => 'array',
    ];

    public function contacts()
    {
        return $this->hasMany(CampaignContact::class);
    }

    public function callerIdDid()
    {
        return $this->belongsTo(DID::class, 'caller_id_did_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dialer()
    {
        return $this->hasOne(Dialer::class);
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->total_contacts == 0) {
            return 0;
        }
        return round(($this->completed_contacts / $this->total_contacts) * 100, 2);
    }
}

class CampaignContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'phone_number',
        'name',
        'custom_data',
        'status',
        'attempts',
        'last_attempt_at',
        'result',
    ];

    protected $casts = [
        'custom_data' => 'array',
        'last_attempt_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
