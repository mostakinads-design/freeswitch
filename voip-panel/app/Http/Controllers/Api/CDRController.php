<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CDR;
use Illuminate\Http\Request;

class CDRController extends Controller
{
    public function index(Request $request)
    {
        $query = CDR::with(['user', 'gateway']);

        // Filter by date range
        if ($request->has('from')) {
            $query->where('start_stamp', '>=', $request->from);
        }
        if ($request->has('to')) {
            $query->where('start_stamp', '<=', $request->to);
        }

        // Filter by direction
        if ($request->has('direction')) {
            $query->where('direction', $request->direction);
        }

        // Filter by caller/destination
        if ($request->has('caller')) {
            $query->where('caller_id_number', 'like', '%' . $request->caller . '%');
        }
        if ($request->has('destination')) {
            $query->where('destination_number', 'like', '%' . $request->destination . '%');
        }

        $cdrs = $query->orderBy('start_stamp', 'desc')
            ->paginate($request->per_page ?? 50);

        return response()->json($cdrs);
    }

    public function show(CDR $cdr)
    {
        return response()->json($cdr->load(['user', 'gateway']));
    }

    public function getRecording(CDR $cdr)
    {
        if (!$cdr->recording_file || !file_exists($cdr->recording_file)) {
            return response()->json(['message' => 'Recording not found'], 404);
        }

        return response()->file($cdr->recording_file);
    }
}
