<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $payoutHours = Payout::getUpcomingPayoutHours();
        $overtimes = $user->overtimes()->orderBy('hours', 'DESC')->unused()->get();
        $offTimes = $user->offTimes()->notExpired()->get();
        $overtimeHours  = floor($overtimes->sum('hours'));
        $overtimeMinutes = convert_to_minutes($overtimeHours) % 60;

        $userStats = compact('overtimeHours', 'overtimeMinutes', 'payoutHours');


        return view('pages.dashboard.index', compact('userStats', 'overtimes', 'offTimes'));
    }
}
