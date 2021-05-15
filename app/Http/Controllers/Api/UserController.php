<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeEmail;
use App\User;
use Illuminate\Http\Request;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Illuminate\Support\Facades\Log;
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
        $users = User::where('team_id', auth()->user()->team->id)->latest()->paginate(10);
        return response()
            ->json(UserResource::collection($users));
    }

    /**
     * @param StoreRequest $request
     * @return void
     */
    public function store(StoreRequest $request)
    {
        $passwordGenerator = new ComputerPasswordGenerator();
        $passwordGenerator->setUppercase()
            ->setLowercase()
            ->setNumbers()
            ->setSymbols()
            ->setLength(10);

        $password = $passwordGenerator->generatePassword();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'team_id' => auth()->user()->team_id,
            'leave_balance' => $request->leave_balance
        ]);

        if ($request->has('is_admin')) {
            $user->attachRole('team-admin', $user->team);
        }

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission) {
                try {
                    $user->attachPermission($permission, $user->team);
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        Mail::to($user->email)->queue(new WelcomeEmail($user, $password));

        return response()
            ->json([
                'message' => 'User created successfully',
                'user' => new UserResource($user)
            ], 201);
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

        if (auth()->user()->team_id !== $user->team_id) {
            return response()
                ->json([
                    'message' => 'You cannot view this user'
                ], 403);
        }

        return response()
            ->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);

        if ($user->team_id !== auth()->user()->team_id) {
            return response()
                ->json([
                    'message' => "You cannot update this user"
                ], 403);
        }

        if ($request->has('is_admin')) {
            $user->attachRole('team-admin', $user->team);
        } else {
            $user->detachRole('team-admin', $user->team);
        }

        if ($request->filled('permissions')) {
            try {
                $user->syncPermissions($request->permissions);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return response()
            ->json([
                'message' => "User roles & permissions updated"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->team_id !== auth()->user()->team_id) {
            return response()
                ->json([
                    'message' => "You delete this user"
                ], 403);
        }

        if (!auth()->user()->hasPermission('can-delete-users', $user->team)) {
            return response()
                ->json([
                    'message' => "You are not allowed to delete users"
                ], 403);
        }

        $user->delete();

        return response()
            ->json([
                'message' => "{$user->name} has been deleted and removed from your team"
            ]);
    }
}
