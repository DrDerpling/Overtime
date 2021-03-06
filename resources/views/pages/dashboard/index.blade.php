@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col l6 m6 s12">
            <div class="row">
                <div class="col l12 m12 s12">
                    @include('pages.offtime.create', ['days' => $overtimeDays + $user->vacation_days])
                </div>
                <div class="col l12 m12 s12">
                    @include('pages.offtime.index', ['offtimes' => $offTimes])
                </div>
            </div>
        </div>
        <div class="col l6 m6 s12">
            <div class="row">
                <div class="col l12 m12 s12">
                    @include('pages.payout.create', ['totalHours' => $totalHours])
                </div>
                <div class="col l12 m12 s12">
                    @include('pages.users.stats', $userStats)
                </div>
            </div>
        </div>
        <div class="col l12 m12 s12">
            @include('pages.overtime.employee.index', ['overtimes' => $overtimes])
        </div>
    </div>

    <div data-target="create-overtime" class="fixed-action-btn modal-trigger">
        <a class="btn-floating btn-large waves-effect waves-light red"><i
                    class="material-icons">add</i></a>
    </div>

    @component('components.modal')
        @slot('open', $errors->has('description') || $errors->has('hours'))
        <div class="row">
            <div class="input-field col l8 m8 s12">
                @component('components.inputs.text-field')
                    {{ old('description') }}
                    @slot('name', 'description')
                    @slot('label', 'Description')
                    @slot('charLength', '50')
                    @slot('error', $errors->first('description'))
                @endcomponent
            </div>
            <div class="input-field col l4 m4 s12">
                @component('components.inputs.text-field')
                    {{ old('hours') }}
                    @slot('name', 'hours')
                    @slot('label', 'hours')
                    @slot('charLength', '4')
                    @slot('error', $errors->first('hours'))
                @endcomponent
            </div>
        </div>
        @slot('id', 'create-overtime')
        @slot('title', 'Log overtime')
        @slot('buttonText', 'Log')
        @slot('method', 'POST')
        @slot('action', route('overtime.store'))
    @endcomponent



@endsection