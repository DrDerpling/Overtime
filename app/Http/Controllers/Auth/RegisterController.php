<?php

namespace App\Http\Controllers\Auth;

use App\Models\Company;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'reg_first_name' => 'required|string|max:50',
            'reg_last_name' => 'required|string|max:50',
            'reg_company_name' => 'required|string|max:50',
            'reg_email' => 'required|string|email|max:255|unique:users,email',
            'reg_password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $company = Company::create(['name' => $data['reg_company_name'] ]);

        return $company->users()->create([
            'first_name' => $data['reg_first_name'],
            'last_name' => $data['reg_last_name'],
            'email' => $data['reg_email'],
            'password' => $data['reg_password'],
            'manager'  => 1
        ]);
    }
}
