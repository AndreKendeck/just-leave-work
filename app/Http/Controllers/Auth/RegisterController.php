<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\General;
use App\Organization;
use App\Providers\RouteServiceProvider;
use App\Team;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255' , 'min:3' ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'team_name' => ['required' , 'string' , 'min:3' ],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'team_name.required' => 'Please enter your organizations name',
            'team_name.min' => 'Organization name must be aleast 3 letters'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // create

        $team = Team::create(['name' => $data['team_name'] ]);
        $user = User::create([
            'name' => $data['name'],
            'team_id' => $team->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('reporter');

        // add permissions to the user
        $user->notify(new General("Welcome to Justleave.work"));
        return $user;
    }
}
