@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col l12 s12 m12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Employee overview</span>

                    @forelse($users as $user)
                        <div class="row row-striped row-narrow">
                            <div class="col l4 m4 s12">
                                <a href="{{ route('user.overtime.index', $user) }}">Name: {{ $user->full_name }} </a>
                            </div>
                            <div class="col l8 m8 s12 ">
                                <div class="col l4 m4 s12">
                                    Vacation days: {{ $user->vacation_days }}
                                </div>
                                <div class="col l4 m4 s12">
                                    Overtime: {{ $user->overtime_hours_floored > 1 ?
                                        $user->overtime_hours_floored. ' H' :
                                        $user->overtime_hours_floored . ' H'}}
                                    {{ $user->overtimeMinutes ?  $user->overtimeMinutes .' Min': '' }}
                                </div>
                                <div class="col l4 m4 s12">
                                    Payout: {{ $user->payout_hours_this_month }}H
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>
                            No Employees found
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection