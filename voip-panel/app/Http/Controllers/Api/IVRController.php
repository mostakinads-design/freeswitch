<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IVR;
use Illuminate\Http\Request;

class IVRController extends Controller
{
    public function index()
    {
        $ivrs = IVR::all();
        return response()->json($ivrs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:ivrs|string',
            'description' => 'nullable|string',
            'greeting_file' => 'nullable|string',
            'greeting_text' => 'nullable|string',
            'use_tts' => 'boolean',
            'timeout' => 'integer|min:1000',
            'max_timeouts' => 'integer|min:1',
            'max_failures' => 'integer|min:1',
            'menu_options' => 'nullable|array',
            'status' => 'in:active,inactive',
        ]);

        $ivr = IVR::create($validated);

        return response()->json($ivr, 201);
    }

    public function show(IVR $ivr)
    {
        return response()->json($ivr);
    }

    public function update(Request $request, IVR $ivr)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'greeting_file' => 'nullable|string',
            'greeting_text' => 'nullable|string',
            'use_tts' => 'boolean',
            'timeout' => 'integer|min:1000',
            'menu_options' => 'nullable|array',
            'status' => 'in:active,inactive',
        ]);

        $ivr->update($validated);

        return response()->json($ivr);
    }

    public function destroy(IVR $ivr)
    {
        $ivr->delete();
        return response()->json(null, 204);
    }

    public function syncToFreeswitch(IVR $ivr)
    {
        // TODO: Generate FreeSWITCH IVR configuration
        return response()->json(['message' => 'IVR synced to FreeSWITCH']);
    }
}
