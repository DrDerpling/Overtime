@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col l12 s12 m12">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col l12 m4 s12">
                            <input
                                    data-maxdays="{{ 8 }}"
                                    id="start_date" name="start_date"
                                    type="text"
                                    class="validate start_datepicker">
                            <label for="start_date">Start date</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection()