<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Services\FreeSwitchESLService;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    protected $esl;

    public function __construct(FreeSwitchESLService $esl)
    {
        $this->esl = $esl;
    }

    public function index()
    {
        $gateways = Gateway::all();
        return response()->json($gateways);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:gateways|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'realm' => 'required|string',
            'proxy' => 'nullable|string',
            'register_proxy' => 'nullable|string',
            'expire_seconds' => 'integer|min:60',
            'register' => 'boolean',
            'transport' => 'in:udp,tcp,tls',
            'status' => 'in:active,inactive',
        ]);

        $gateway = Gateway::create($validated);

        return response()->json($gateway, 201);
    }

    public function show(Gateway $gateway)
    {
        return response()->json($gateway);
    }

    public function update(Request $request, Gateway $gateway)
    {
        $validated = $request->validate([
            'username' => 'string',
            'password' => 'string',
            'realm' => 'string',
            'proxy' => 'nullable|string',
            'register' => 'boolean',
            'status' => 'in:active,inactive',
        ]);

        $gateway->update($validated);

        return response()->json($gateway);
    }

    public function destroy(Gateway $gateway)
    {
        $gateway->delete();
        return response()->json(null, 204);
    }

    public function syncToFreeswitch(Gateway $gateway)
    {
        // TODO: Generate and write gateway configuration
        $this->esl->reloadXml();
        return response()->json(['message' => 'Gateway synced to FreeSWITCH']);
    }
}
