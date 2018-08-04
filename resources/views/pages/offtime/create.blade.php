@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col l12 s12 m12">
            <div class="card">
                <form action="{{ route('off_time.store') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <div class="card-content">
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <input data-maxdays="{{ $days - 1 }}"
                                       id="start_date" name="start_date"
                                       type="text"
                                       class="start_datepicker">
                                <label for="start_date">Select off date(s)</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col m12 l12  s12 ">
                                @component('components.inputs.checkbox')
                                    @slot('label', 'Use vacation days first')')
                                    @slot('name', 'vacation_days' )
                                @endcomponent
                            </div>
                        </div>

                        <div class="row">
                            <div class="col l12 s12 m12">
                                Days available: <span id="daysLeft">{{ $days }}</span> <br>
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