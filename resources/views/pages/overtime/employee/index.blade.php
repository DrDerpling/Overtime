@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col l12 s12 m12">
            <div class="card">
                <form action="{{ route('overtime.update') }}" method="post">
                    {{ csrf_field()  }}
                    {{ method_field('PUT') }}
                    <div class="card-content">
                        <span class="card-title">Overtime overview</span>
                        @forelse ($overtimes as $overtime)
                            <div class="row row-striped valign-wrapper">
                                @if(!$overtime->isUsed())
                                    <div class="col m1 l1  s1 ">
                                        @component('components.inputs.checkbox')
                                            {{ $overtime->id }}
                                            @slot('label', '')
                                            @slot('name', 'use[]')
                                            @slot('checked', $overtime->isUsed())
                                        @endcomponent
                                    </div>
                                @endif
                                <div for class="col l11 m11 s11">
                                    <div class="col l2 m4 s12">
                                        {{ $overtime->created_at->format('H:i d-m-Y') }}
                                    </div>
                                    <div class="col l2 m2 s12">
                                        {{ $overtime->hours }} Hours
                                    </div>
                                    <div class="col l7 m5 s12">
                                        {{ $overtime->description }}
                                    </div>
                                </div>
                            </div>
                            @if($loop->last)
                                <div class="row row-striped valign-wrapper">
                                    <div class="col offset-l3 l9 offset-m5 m7 s12">
                                        Total: {{ floor($overtimes->sum('hours')) }} Hours <br>
                                        Total: {{ floor($overtimes->sum('hours') / 8) }} Days
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p>No overtime was found</p>
                        @endforelse
                    </div>
                    <div class="card-action">
                        <button class="waves-effect waves-light btn" value="1" name="off_time" type="submit">Use
                            selected for off time
                        </button>
                        <button class="waves-effect waves-light btn" value="1" name="payout" type="submit">Payout
                            selected
                        </button>
                    </div>
                </form>
            </div>
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