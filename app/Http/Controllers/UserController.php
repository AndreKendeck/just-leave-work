<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\User\Invation;
use App\Notifications\General;
use App\Permission;
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
        if (auth()->user()->is_leader) {
            return view('users.index', [
                'users' => auth()->user()->organization()->users()->paginate()
            ]);
        }
        abort(403, "You cannot access this page");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->is_leader) {
            return view('users.create', [
                'permissions' => Permission::all()
            ]);
        }
        abort(403, "You cannot access this page");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $generator = new ComputerPasswordGenerator();
        $generator->setUppercase()
        ->setLowercase()
        ->setNumbers()
        ->setSymbols(true)
        ->setLength(10);

        $password = $generator->generatePassword();

        $user = User::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);
        Mail::to($user->email)->queue(new Invation($user, $password));
        $user->notify(new General(
            "Welcome to JustLeave {$user->name} an eaiser way to manage your leaves",
            route('index')
        ));
        // sync Permissions
        $user->syncPermissions($request->permissions, auth()->user()->organization);
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
        if (!auth()->user()->is_leader) {
            abort(403, "You are not allowed to view this page");
        }
        $user = User::findOrFail($id);

        if (auth()->user()->organization_id != $user->organization_id) {
            abort(403, "You cannot view this profile");
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
        if (!auth()->user()->is_leader) {
            abort(403, "You are not allowed to view this page");
        }
        $user = User::findOrFail($id);

        if (auth()->user()->organization_id != $user->organization_id) {
            abort(403, "You cannot view this profile");
        }

        return view('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (!auth()->user()->areTeammates($user)) {
            abort(403, "You cannot perform this action ");
        }
        $user->syncPermissions($request->permissions, $user->organization);
        return redirect()->back()->with('message', "User updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // not allowed
    }
}
