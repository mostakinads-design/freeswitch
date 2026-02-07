<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Services\FreeSwitchESLService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ExtensionController extends Controller
{
    protected $esl;

    public function __construct(FreeSwitchESLService $esl)
    {
        $this->esl = $esl;
    }

    public function index()
    {
        $extensions = Extension::with('user')->get();
        return response()->json($extensions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'extension' => 'required|unique:extensions|max:20',
            'user_id' => 'nullable|exists:users,id',
            'password' => 'required|min:8',
            'name' => 'required|string',
            'voicemail_password' => 'nullable|string',
            'voicemail_enabled' => 'boolean',
            'caller_id_name' => 'nullable|string',
            'caller_id_number' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $extension = Extension::create($validated);

        // Sync to FreeSWITCH
        $this->syncExtensionToFreeswitch($extension);

        return response()->json($extension, 201);
    }

    public function show(Extension $extension)
    {
        return response()->json($extension->load('user'));
    }

    public function update(Request $request, Extension $extension)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'password' => 'sometimes|min:8',
            'name' => 'required|string',
            'voicemail_password' => 'nullable|string',
            'voicemail_enabled' => 'boolean',
            'caller_id_name' => 'nullable|string',
            'caller_id_number' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $extension->update($validated);

        // Sync to FreeSWITCH
        $this->syncExtensionToFreeswitch($extension);

        return response()->json($extension);
    }

    public function destroy(Extension $extension)
    {
        $extension->delete();
        
        // Reload FreeSWITCH XML
        $this->esl->reloadXml();

        return response()->json(null, 204);
    }

    public function syncToFreeswitch(Extension $extension)
    {
        $this->syncExtensionToFreeswitch($extension);
        return response()->json(['message' => 'Extension synced successfully']);
    }

    protected function syncExtensionToFreeswitch(Extension $extension)
    {
        // Generate XML configuration for the extension
        $xml = $this->generateExtensionXml($extension);
        
        // Write to FreeSWITCH directory structure
        $configPath = config('freeswitch.conf_path', '/etc/freeswitch');
        $extensionFile = "{$configPath}/directory/default/{$extension->extension}.xml";
        
        file_put_contents($extensionFile, $xml);
        
        // Reload FreeSWITCH XML
        $this->esl->reloadXml();
    }

    protected function generateExtensionXml(Extension $extension)
    {
        $template = file_get_contents(base_path('freeswitch-config/directory/user_template.xml'));
        
        $replacements = [
            '{{extension}}' => $extension->extension,
            '{{password}}' => $extension->password,
            '{{voicemail_password}}' => $extension->voicemail_password ?? '1234',
            '{{voicemail_enabled}}' => $extension->voicemail_enabled ? 'true' : 'false',
            '{{caller_id_name}}' => $extension->caller_id_name ?? $extension->name,
            '{{caller_id_number}}' => $extension->caller_id_number ?? $extension->extension,
            '{{callgroup}}' => $extension->settings['callgroup'] ?? 'default',
            '{{record_calls}}' => $extension->settings['record_calls'] ?? 'false',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }
}
