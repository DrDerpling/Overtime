@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col l12 s12 m12">
            <div class="card">
                <form action="{{ route('off_time.update', $offTime) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="card-content">
                        <div class="row">
                            <div class="input-field col l6 m6 s6">
                                <input data-maxdays="{{ $days }}"
                                       id="start_date" name="start_date"
                                       type="text"
                                       class="start_datepicker">
                                <label for="start_date">Start date</label>
                            </div>
                            <div class="input-field col l6 m6 s6">
                                <input data-maxdays="{{ $days }}"
                                       id="end_date" name="end_date"
                                       type="text"
                                       class="end_datepicker">
                                <label for="end_date">End date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col m12 l12  s12 ">
                                @component('components.inputs.checkbox')
                                        {{ $vacationDays }}
                                    @slot('label', 'Use vacation days (Days left: ' . $vacationDays .')')
                                    @slot('name', 'vacation_days' )
                                @endcomponent
                            </div>
                        </div>

                        <div class="row">
                            <p><strong>Note:</strong> Remaining minutes will be payed out</p>
                        </div>

                        <div class="row">
                            <div class="col l12 s12 m12">
                                Days available: <span id="daysLeft">{{ $days }}</span> <br>
                                Minutes remaining: {{ $minutesLeft }}
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="waves-effect waves-light btn" value="1" name="off_time" type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection()