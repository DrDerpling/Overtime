<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $overtimes = Overtime::calcRequiredOvertime(
            $request->input('payout_hours'),
            $user->overtimes()->unused()->get()
        );
        if ($overtimes) {
            $payout = auth()->user()->payouts()->create([
                'minutes' => convert_to_minutes($request->input('payout_hours'))
            ]);
            $payout->overtimes()->sync($overtimes->pluck('id'));
            $payout->overtimes()->update(['paid_out' => 1]);
        }

        return redirect()->back()->with(['message' => 'Payout logged successfully']);
    }
}
