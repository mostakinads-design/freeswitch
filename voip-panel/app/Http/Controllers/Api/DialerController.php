<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dialer;
use Illuminate\Http\Request;

class DialerController extends Controller
{
    public function index()
    {
        $dialers = Dialer::with(['queue', 'campaign'])->get();
        return response()->json($dialers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:preview,progressive,predictive,power',
            'queue_id' => 'nullable|exists:queues,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'ratio' => 'numeric|min:1|max:5',
            'max_lines' => 'integer|min:1',
            'answer_timeout' => 'integer|min:5',
            'amd_enabled' => 'boolean',
            'ai_enabled' => 'boolean',
            'ai_mode' => 'in:human,ai,hybrid',
            'status' => 'in:active,inactive',
        ]);

        $dialer = Dialer::create($validated);

        return response()->json($dialer, 201);
    }

    public function show(Dialer $dialer)
    {
        return response()->json($dialer->load(['queue', 'campaign']));
    }

    public function update(Request $request, Dialer $dialer)
    {
        $validated = $request->validate([
            'name' => 'string',
            'ratio' => 'numeric|min:1|max:5',
            'max_lines' => 'integer|min:1',
            'amd_enabled' => 'boolean',
            'ai_enabled' => 'boolean',
            'ai_mode' => 'in:human,ai,hybrid',
            'status' => 'in:active,inactive',
        ]);

        $dialer->update($validated);

        return response()->json($dialer);
    }

    public function destroy(Dialer $dialer)
    {
        if ($dialer->status === 'active') {
            return response()->json(['message' => 'Cannot delete active dialer'], 400);
        }

        $dialer->delete();
        return response()->json(null, 204);
    }

    public function start(Dialer $dialer)
    {
        $dialer->update(['status' => 'active']);
        
        // TODO: Start dialer process
        
        return response()->json(['message' => 'Dialer started']);
    }

    public function stop(Dialer $dialer)
    {
        $dialer->update(['status' => 'inactive']);
        
        // TODO: Stop dialer process
        
        return response()->json(['message' => 'Dialer stopped']);
    }
}
