<?php

namespace App\Http\Controllers;

use App\Models\OffTime;
use App\Models\Overtime;
use App\Models\User;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager')->except(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $overtimes = $user->overtimes()->unused()->get();

        return view('pages.overtime.manager.index', compact('overtimes', 'user'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Overtime::whereIn('id', $request->input('use'))->update([
            'off_time' => $request->has('off_time'),
            'paid_out' => $request->has('paid_out')
        ]);

        return redirect()->back()->with(['message', 'Overtime successfully updated']);
    }
}
