<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Mail\User\Invation;
use App\User;
use Illuminate\Http\Request;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            'users' => auth()->user()->team()->users()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $generator = new ComputerPasswordGenerator();
        $generator->setUppercase()
        ->setLowercase()
        ->setNumbers()
        ->setSymbols(true)
        ->setLength(10);

        $password = $generator->generatePassword();

        $user = User::create([
            'team_id' => auth()->user()->team_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);
        Mail::to($user->email)->queue(new Invation($user, $password));

        return redirect()->back()->with('message', "User {$user->name} has been created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == auth()->user()->id) {
            return redirect()->route('profile');
        }
        if ($user->team_id != auth()->user()->team_id) {
            abort(403, "You are not allowed to view this page");
        }
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //not allowed
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //not allowed
    }
}
