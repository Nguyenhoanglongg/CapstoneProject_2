<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Models\AdminSettings;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;

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
     * Where to redirect users after login / registration.
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


        $messages = [
            'countries_id.required' => trans('misc.please_select_country'),

        ];

        return Validator::make($data, [
            'name' => 'required|string|max:255|not_regex:/^[!@#$%\^&*)(+=._-]*$/',
            'email' => 'required|email|min:8|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'countries_id'     => 'required',
            'agree_gdpr' => 'required',

        ], $messages);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {




        $token = str_random(75);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'countries_id' => $data['countries_id'],
            'avatar' => 'default.jpg',

            'role' => 'normal',
            'token' => $token,

        ]);
    }

    public function showRegistrationForm()
    {
        $settings = AdminSettings::first();

        if ($settings->registration_active == 'on') {
            return view('auth.register');
        } else {
            return redirect('/');
        }
    }
}
