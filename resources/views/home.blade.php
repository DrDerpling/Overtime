@extends('layouts.app')

@section('content')
    <!-- Modal Trigger -->
    <button data-target="modal1" class="btn modal-trigger">Modal</button>

    @component('components.modal')
        @slot('id', 'modal1')
        @slot('title', 'this is the title')
        @slot('method', 'PUT')
        @slot('action', url('/'))
    @endcomponent
@endsection
