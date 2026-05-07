<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DID;
use Illuminate\Http\Request;

class DIDController extends Controller
{
    public function index()
    {
        $dids = DID::with('gateway')->get();
        return response()->json($dids);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:dids|string|max:20',
            'country_code' => 'string|max:5',
            'destination_type' => 'required|in:extension,ivr,ring_group,queue,conference,external',
            'destination_value' => 'required|string',
            'gateway_id' => 'nullable|exists:gateways,id',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        $did = DID::create($validated);

        return response()->json($did, 201);
    }

    public function show(DID $did)
    {
        return response()->json($did->load('gateway'));
    }

    public function update(Request $request, DID $did)
    {
        $validated = $request->validate([
            'destination_type' => 'in:extension,ivr,ring_group,queue,conference,external',
            'destination_value' => 'string',
            'gateway_id' => 'nullable|exists:gateways,id',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        $did->update($validated);

        return response()->json($did);
    }

    public function destroy(DID $did)
    {
        $did->delete();
        return response()->json(null, 204);
    }
}
