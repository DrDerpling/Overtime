<?php

namespace App\Http\Controllers;

use App\Models\OffTime;
use App\Models\Overtime;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($user = auth()->user()) {
            if ($user->isManager()) {

            } else {
                $overtimes = $user->overtimes()->orderBy('hours', 'DESC')->active()->get();
                return view('pages.overtime.employee.index', compact('overtimes'));
            }
        }
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($user = auth()->user()) {
            $user->overtimes()->create($request->all());
        }

        return redirect()->back()->with(['message', 'Overtime logged successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Overtime $overtime
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtime $overtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Overtime $overtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->has('payout')) {
            Overtime::whereIn('id', $request->input('use'))->update(['paid_out' => 1]);
            return redirect()->back()->with(['message', 'Overtime successfully updated']);
        } elseif ($request->has('off_time')) {
            $array = Overtime::getDaysWithRemainder(['ids' => $request->input('use')]);
            $days = $array['days'];
            $minutesLeft = $array['minutesLeft'];

            if ($days < 1) {
                return redirect()->back()->withErrors(['insouciant_days', 'Not enough time was given for a off time']);
            }

            $offTime = OffTime::create();
            $offTime->overtimes()->sync($request->input('use'));
            return view('pages.overtime.employee.rangepicker', compact('days', 'minutesLeft', 'offTime'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Overtime $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtime $overtime)
    {
        //
    }
}
