<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FreeSwitchESLService;
use Illuminate\Http\Request;

class CallController extends Controller
{
    protected $esl;

    public function __construct(FreeSwitchESLService $esl)
    {
        $this->esl = $esl;
    }

    public function live()
    {
        $channels = $this->esl->getChannels();
        
        $calls = collect($channels)->map(function ($channel) {
            return [
                'uuid' => $channel['uuid'] ?? '',
                'from' => $channel['caller_id_number'] ?? 'Unknown',
                'to' => $channel['dest'] ?? 'Unknown',
                'duration' => $this->formatDuration($channel['created_epoch'] ?? 0),
                'status' => $channel['callstate'] ?? 'ACTIVE',
            ];
        });

        return response()->json($calls);
    }

    public function hangup(Request $request, $uuid)
    {
        $result = $this->esl->hangup($uuid);

        if ($result['success']) {
            return response()->json(['message' => 'Call hung up successfully']);
        }

        return response()->json(['message' => 'Failed to hang up call'], 500);
    }

    public function originate(Request $request)
    {
        $validated = $request->validate([
            'extension' => 'required|string',
            'destination' => 'required|string',
        ]);

        $result = $this->esl->originate(
            "user/{$validated['extension']}",
            $validated['destination']
        );

        if ($result['success']) {
            return response()->json(['message' => 'Call originated successfully']);
        }

        return response()->json(['message' => 'Failed to originate call'], 500);
    }

    protected function formatDuration($createdEpoch)
    {
        if (!$createdEpoch) {
            return '00:00';
        }

        $duration = time() - $createdEpoch;
        $minutes = floor($duration / 60);
        $seconds = $duration % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
