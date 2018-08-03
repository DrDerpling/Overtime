<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('pages.payout.index', compact('hours'));
    }
}
