<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CDR;
use App\Models\User;
use App\Services\FreeSwitchESLService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $esl;

    public function __construct(FreeSwitchESLService $esl)
    {
        $this->esl = $esl;
    }

    public function stats()
    {
        // Get live stats from FreeSWITCH
        $channels = $this->esl->getChannels();
        $activeCalls = count($channels);

        // Get agents online (you'd implement this based on your agent tracking)
        $onlineAgents = User::where('role', 'agent')
            ->where('status', 'active')
            ->count();

        // Get calls today
        $callsToday = CDR::whereDate('start_stamp', today())->count();

        // Get revenue today
        $revenueToday = CDR::whereDate('start_stamp', today())
            ->sum('cost');

        return response()->json([
            'activeCalls' => $activeCalls,
            'onlineAgents' => $onlineAgents,
            'callsToday' => $callsToday,
            'revenueToday' => number_format($revenueToday, 2),
        ]);
    }
}
