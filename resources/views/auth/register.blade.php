@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col l6 s12">
            <div class="card">
                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <div class="card-content">
                        <span class="card-title">Memeber login</span>
                        <div class="row">
                            <div class="input-field col s12">
                                @component('components.inputs.text-field')
                                    @slot('name', 'email')
                                    @slot('label', 'Email address')
                                    @slot('charLength', '50')
                                    @slot('error', $errors->first('email'))
                                @endcomponent
                            </div>
                            <div class="input-field col s12">
                                @component('components.inputs.password-field')
                                    @slot('name', 'password')
                                    @slot('label', 'Password')
                                    @slot('charLength', '50')
                                    @slot('error', $errors->first('password'))
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="waves-effect waves-light btn" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col l6 s12">
            <div class="card">
                <form action="{{ route('register') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <div class="card-content">
                        <span class="card-title">Registration</span>
                        <div class="row">
                            <div class="input-field col s12">
                                @component('components.inputs.text-field')
                                    @slot('name', 'first_name')
                                    @slot('label', 'First name')
                                    @slot('charLength', '50')
                                    @slot('error', $errors->first('first_name'))
                                @endcomponent
                            </div>
                            <div class="input-field col s12">
                                @component('components.inputs.text-field')
                                    @slot('name', 'last_name')
                                    @slot('label', 'Last name')
                                    @slot('charLength', '50')
                                    @slot('error', $errors->first('last_name'))
                                @endcomponent
                            </div>
                            <div class="input-field col s12">
                                @component('components.inputs.text-field')
                                    @slot('name', 'email')
                                    @slot('label', 'Email address')
                                    @slot('charLength', '50')
                                    @slot('error', $errors->first('email'))
                                @endcomponent
                            </div>
                            <div class="input-field col s12">
                                @component('components.inputs.text-field')
                                    @slot('name', 'company_name')
                                    @slot('label', 'Company name')
                                    @slot('charLength', '50')
                                    @slot('error', $errors->first('company_name'))
                                @endcomponent
                            </div>
                            <div class="input-field col s12">
                                @component('components.inputs.password-field')
                                    @slot('name', 'password')
                                    @slot('label', 'Password')
                                    @slot('charLength', '50')
                                    @slot('error', $errors->first('password'))
                                @endcomponent
                            </div>
                            <div class="input-field col s12">
                                @component('components.inputs.password-field')
                                    @slot('name', 'password_confirmation')
                                    @slot('label', 'Confirm password')
                                    @slot('charLength', '50')
                                    @slot('error', $errors->first('password_confirmation'))
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="waves-effect waves-light btn" type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
