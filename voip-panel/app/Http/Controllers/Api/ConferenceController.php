<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::all();
        return response()->json($conferences);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:conferences|string',
            'pin' => 'nullable|string',
            'moderator_pin' => 'nullable|string',
            'max_members' => 'integer|min:2',
            'record' => 'boolean',
            'video_enabled' => 'boolean',
            'profile' => 'string',
            'status' => 'in:active,inactive',
        ]);

        $conference = Conference::create($validated);

        return response()->json($conference, 201);
    }

    public function show(Conference $conference)
    {
        return response()->json($conference);
    }

    public function update(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'pin' => 'nullable|string',
            'moderator_pin' => 'nullable|string',
            'max_members' => 'integer|min:2',
            'record' => 'boolean',
            'video_enabled' => 'boolean',
            'status' => 'in:active,inactive',
        ]);

        $conference->update($validated);

        return response()->json($conference);
    }

    public function destroy(Conference $conference)
    {
        $conference->delete();
        return response()->json(null, 204);
    }

    public function participants(Conference $conference)
    {
        // TODO: Get live participants from FreeSWITCH
        return response()->json([]);
    }
}
