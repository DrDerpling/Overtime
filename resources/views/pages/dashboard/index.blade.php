@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col l6 m6 s12">
            @include('pages.offtime.index', ['offtimes' => $offTimes])
        </div>
        <div class="col offset-l2 l4 m6 s12">
            @include('pages.payout.index', ['hours' => $payoutHours])
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">
            @include('pages.overtime.employee.index', ['overtimes' => $overtimes])
        </div>
    </div>

    <div data-target="create-overtime" class="fixed-action-btn modal-trigger">
        <a class="btn-floating btn-large waves-effect waves-light red"><i
                    class="material-icons">add</i></a>
    </div>

    @component('components.modal')
        <div class="row">
            <div class="input-field col l10 m8 s12">
                @component('components.inputs.text-field')
                    {{ old('first_name') }}
                    @slot('name', 'description')
                    @slot('label', 'Description')
                    @slot('charLength', '50')
                    @slot('error', $errors->first('first_name'))
                @endcomponent
            </div>
            <div class="input-field col l2 m4 s12">
                @component('components.inputs.text-field')
                    {{ old('first_name') }}
                    @slot('name', 'hours')
                    @slot('label', 'hours')
                    @slot('charLength', '4')
                    @slot('error', $errors->first('first_name'))
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