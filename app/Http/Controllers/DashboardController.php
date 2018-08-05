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
        $totalHours = $overtimes->sum('hours');

        $overtimeHours = floor(convert_to_minutes($totalHours) / 60);
        $overtimeDays = getDays($totalHours);
        $overtimeMinutes = convert_to_minutes($totalHours) %  60;

        $userStats = compact('overtimeHours', 'overtimeMinutes', 'payoutHours');


        return view(
            'pages.dashboard.index',
            compact('userStats', 'overtimes', 'offTimes', 'user', 'totalHours', 'overtimeDays')
        );
    }
}
