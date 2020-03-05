<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Organization;
use App\Providers\RouteServiceProvider;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'organization_name' => ['required' , 'string' , 'min:3' ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $organization = Organization::create([
            'name' => $data['organization_name'],
            'display_name' => $data['organization_name']
        ]);
        $user = User::create([
            'name' => $data['name'],
            'organization_id' => $organization->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $organization->update([
            'leader_id' => $user->id 
        ]); 
        
        // add permissions to the user
        $user->syncPermissions(['approve-and-deny-leave' , 'add-user' , 'remove-user'] , $organization );
        return $user;
    }
}
