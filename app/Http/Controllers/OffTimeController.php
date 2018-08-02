<?php

namespace App\Http\Controllers;

use App\Models\OffTime;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OffTime  $offTime
     * @return \Illuminate\Http\Response
     */
    public function show(OffTime $offTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OffTime  $offTime
     * @return \Illuminate\Http\Response
     */
    public function edit(OffTime $offTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OffTime  $offTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OffTime $offTime)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
        $end_date = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        $diff = $end_date->diffInDays($start_date) + 1;

        $array = Overtime::getDaysWithRemainder(['hours' => $offTime->overtimes->sum('hours')]);
        $days = $array['days'];
        $minutesLeft = $array['minutesLeft'];

        if ($diff !== $days) {
            return redirect()->back()->withErrors(['errors' => 'Please use all days']);
        }

        if ($minutesLeft) {

        }

        $offTime->update([
           'start_date' => $start_date,
           'end_date' => $end_date
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OffTime  $offTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(OffTime $offTime)
    {
        //
    }
}
