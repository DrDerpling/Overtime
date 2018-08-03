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
        $offTimes = auth()->user()->offTimes()->notExpired()->get();


        return view('pages.dashboard.index', compact('payoutHours', 'overtimes', 'offTimes'));
    }
}
