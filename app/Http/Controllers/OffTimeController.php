<?php

namespace App\Http\Controllers;

use App\Models\OffTime;
use App\Models\Payout;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Overtime;

class OffTimeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        $days = getDays($user->overtimes()->unused()->sum('hours')) + $user->vacation_days;

        if ($days < 1) {
            return redirect()->back()->withErrors(['insouciant_days', 'Not enough time was given for off time']);
        }

        return view('pages.offtime.create', compact('days'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OffTime $offTime
     * @return \Illuminate\Http\Response
     */
    public function edit(OffTime $offTime)
    {
        $days = $offTime->daysAvailable();

        return view('pages.offtime.edit', compact('days', 'minutesLeft', 'offTime', 'vacationDays'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param OffTime $offTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OffTime $offTime)
    {
        $dates = explode(' ', $request->input('start_date'));

        $start_date = Carbon::createFromFormat('Y-m-d', array_get($dates, 0));
        $end_date = Carbon::createFromFormat('Y-m-d', array_get($dates, 2));

        $days = $start_date->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend();
            },
                $end_date
            ) + 1;
        if ($offTime->daysAvailable() !== $days) {
            return redirect()->back()->withErrors(['errors' => 'Please use all days']);
        }

        $offTime->update(
            [
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]
        );

        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $availableDays = getDays($user->overtimes()->unused()->sum('hours')) + $user->vacation_days;

        $dates = explode(' ', $request->input('start_date'));

        $start_date = Carbon::createFromFormat('Y-m-d', array_get($dates, 0));
        $end_date = Carbon::createFromFormat('Y-m-d', array_get($dates, 2));

        $days = $start_date->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend();
            },
                $end_date
            ) + 1;
        if ($days > $availableDays) {
            return redirect()->back()->withErrors(['errors' => 'You don\'t have that many days to use']);
        }
        $offTime = $user->offTimes()->create(
            [
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]
        );

        if ($request->has('vacation_days')) {
            $days = $user->updateVacationDays($offTime, $days);
            if ($days) {
                $overtimes = Overtime::getRequiredOverTimes($days, $offTime);
            }
        } else {
            $overtimes = Overtime::getRequiredOverTimes($days, $offTime);
            $overtimeDays = getDays($overtimes->sum('hours'));
            if ($overtimeDays !== $days) {
                $user->updateVacationDays($offTime, $days - $overtimeDays);
            }
        }
        if (isset($overtimes) && $overtimes->count()) {
            $offTime->overtimes()->sync($overtimes->pluck('id'));
            $offTime->overtimes()->update(['off_time' => 1]);
        }

        return redirect()->route('home')->with(['message' => 'Off time logged successfully']);
    }
}
