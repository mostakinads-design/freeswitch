<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with(['callerIdDid', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($campaigns);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:voice,sms',
            'message' => 'required_if:type,sms|nullable|string',
            'audio_file' => 'required_if:type,voice|nullable|file|mimes:wav,mp3',
            'caller_id_did_id' => 'nullable|exists:dids,id',
            'scheduled_at' => 'nullable|date',
        ]);

        if ($request->hasFile('audio_file')) {
            $validated['audio_file'] = $request->file('audio_file')->store('campaigns/audio');
        }

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'draft';

        $campaign = Campaign::create($validated);

        return response()->json($campaign, 201);
    }

    public function show(Campaign $campaign)
    {
        return response()->json($campaign->load(['contacts', 'callerIdDid', 'creator']));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'name' => 'string',
            'message' => 'nullable|string',
            'caller_id_did_id' => 'nullable|exists:dids,id',
            'scheduled_at' => 'nullable|date',
        ]);

        $campaign->update($validated);

        return response()->json($campaign);
    }

    public function destroy(Campaign $campaign)
    {
        if (in_array($campaign->status, ['running'])) {
            return response()->json(['message' => 'Cannot delete running campaign'], 400);
        }

        $campaign->delete();

        return response()->json(null, 204);
    }

    public function importContacts(Request $request, Campaign $campaign)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $csv = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($csv);

        $contacts = [];
        $count = 0;

        foreach ($csv as $row) {
            if (count($row) < 1) continue;

            $data = array_combine($header, $row);
            
            $contact = [
                'campaign_id' => $campaign->id,
                'phone_number' => $data['phone_number'] ?? $data['phone'] ?? $row[0],
                'name' => $data['name'] ?? null,
                'custom_data' => $data,
                'status' => 'pending',
                'attempts' => 0,
            ];

            CampaignContact::create($contact);
            $count++;
        }

        $campaign->update(['total_contacts' => $campaign->total_contacts + $count]);

        return response()->json([
            'message' => "Imported $count contacts",
            'total' => $campaign->total_contacts
        ]);
    }

    public function start(Campaign $campaign)
    {
        if ($campaign->status === 'running') {
            return response()->json(['message' => 'Campaign already running'], 400);
        }

        $campaign->update(['status' => 'running']);

        // TODO: Dispatch job to process campaign
        // ProcessCampaign::dispatch($campaign);

        return response()->json(['message' => 'Campaign started']);
    }

    public function pause(Campaign $campaign)
    {
        $campaign->update(['status' => 'paused']);
        return response()->json(['message' => 'Campaign paused']);
    }

    public function stop(Campaign $campaign)
    {
        $campaign->update(['status' => 'completed']);
        return response()->json(['message' => 'Campaign stopped']);
    }
}
