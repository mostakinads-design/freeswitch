<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\User;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::with('members')->get();
        return response()->json($queues);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:queues|string',
            'description' => 'nullable|string',
            'strategy' => 'required|in:ring-all,longest-idle-agent,round-robin,top-down,agent-with-least-talk-time,sequentially-by-agent-order',
            'moh_sound' => 'nullable|string',
            'timeout' => 'integer|min:1',
            'max_wait_time' => 'integer|min:1',
            'max_wait_time_with_no_agent' => 'integer|min:1',
            'record_calls' => 'boolean',
            'status' => 'in:active,inactive',
        ]);

        $queue = Queue::create($validated);

        return response()->json($queue, 201);
    }

    public function show(Queue $queue)
    {
        return response()->json($queue->load('members'));
    }

    public function update(Request $request, Queue $queue)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'strategy' => 'in:ring-all,longest-idle-agent,round-robin,top-down,agent-with-least-talk-time,sequentially-by-agent-order',
            'moh_sound' => 'nullable|string',
            'timeout' => 'integer|min:1',
            'max_wait_time' => 'integer|min:1',
            'record_calls' => 'boolean',
            'status' => 'in:active,inactive',
        ]);

        $queue->update($validated);

        return response()->json($queue);
    }

    public function destroy(Queue $queue)
    {
        $queue->delete();
        return response()->json(null, 204);
    }

    public function addMember(Request $request, Queue $queue)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'level' => 'integer|min:1|max:10',
            'position' => 'integer|min:1',
        ]);

        $queue->members()->attach($validated['user_id'], [
            'level' => $validated['level'] ?? 1,
            'position' => $validated['position'] ?? 1,
            'status' => 'available',
        ]);

        return response()->json(['message' => 'Member added to queue']);
    }

    public function removeMember(Queue $queue, User $user)
    {
        $queue->members()->detach($user->id);
        return response()->json(['message' => 'Member removed from queue']);
    }
}
