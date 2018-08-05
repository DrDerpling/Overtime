@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col l12 s12 m12">
            <div class="card">
                <form action="{{ route('overtime.update') }}" method="post">
                    {{ csrf_field()  }}
                    {{ method_field('PUT') }}
                    <div class="card-content">
                        <span class="card-title">Overtime overview ({{ $user->full_name }})</span>
                        @forelse ($overtimes as $overtime)
                            <div class="row row-striped row-narrow valign-wrapper">
                                <div class="col m1 l1  s1 ">
                                    @component('components.inputs.checkbox')
                                        {{ $overtime->id }}
                                        @slot('label', '')
                                        @slot('name', 'use[]')
                                        @slot('checked', $overtime->isUsed())
                                    @endcomponent
                                </div>
                                <div for class="col l11 m11 s11">
                                    <div class="col l3 m5 s12">
                                        {{ $overtime->created_at->format('H:i d-m-Y') }}
                                    </div>
                                    <div class="col l2 m2 s12">
                                        {{ $overtime->hours }}H
                                    </div>
                                    <div class="col l6 m5 s12">
                                        {{ $overtime->description }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No overtime was found</p>
                        @endforelse
                    </div>
                    @if($overtimes->count())
                        <div class="card-action">
                            <div class="row row-stacked">
                                <div class="col l6 m6 s12">
                                    <button  class="btn-flat waves-effect waves-light btn" type="submit" name="off_time" href="{{ route('overtime.update') }}">
                                        Mark selected as off period
                                    </button>
                                </div>
                                <div class="col l6 m6 s12 right-align">
                                    <button class=" btn-flat waves-effect waves-light btn" type="submit" name="paid_out" href="{{ route('overtime.update') }}">
                                        Mark selected as paid out
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection()