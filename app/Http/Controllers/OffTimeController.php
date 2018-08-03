<?php

namespace App\Http\Controllers;

use App\Models\OffTime;
use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Overtime;

class OffTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offTimes = auth()->user()->offTimes()->notExpired()->get();

        return view('pages.offtime.index', compact('offTimes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OffTime $offTime
     * @return \Illuminate\Http\Response
     */
    public function show(OffTime $offTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OffTime $offTime
     * @return \Illuminate\Http\Response
     */
    public function edit(OffTime $offTime)
    {
        $hours = $offTime->overtimes->sum('hours');
        $days = getDays($hours);
        $minutesLeft = getRemainingMinutes($hours);

        if ($days < 1) {
            return redirect()->back()->withErrors(['insouciant_days', 'Not enough time was given for a off time']);
        }

        return view('pages.offtime.edit', compact('days', 'minutesLeft', 'offTime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\OffTime $offTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OffTime $offTime)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
        $end_date = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));

        $diff = $start_date->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend();
            }, $end_date) + 1;

        $overtimes = $offTime->overtimes;

        $hours = $overtimes->sum('hours');
        $days = getDays($hours);
        $minutesLeft = getRemainingMinutes($hours);

        if ($diff !== (int)$days) {
            return redirect()->back()->withErrors(['errors' => 'Please use all days']);
        }

        if ($minutesLeft !== 0) {
            //Check if a payout exist
            $payout = Payout::whereHas('overtimes', function ($query) use ($overtimes) {
                $query->whereIn('id', $overtimes->pluck('id'));
            })->first();
            if ($payout) {
                $payout->update(['minutes' => $minutesLeft]);
            } else {
                $payout = $offTime->user->payouts()->create(['minutes' => $minutesLeft]);
                $payout->overtimes()->sync($offTime->overtimes);
            }
        }
        $offTime->update([
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);

        return redirect()->route('off_time.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OffTime $offTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(OffTime $offTime)
    {
        //
    }
}
