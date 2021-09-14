<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeEmail;
use App\Transaction;
use App\User;
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

        if (request()->get('search')) {
            $search = request()->get('search');
            $users = User::where('team_id', auth()->user()->team->id)->where('name', 'like', "{$search}%")
                ->latest()->paginate(10);
        }

        return response()
            ->json([
                'users' => UserResource::collection($users),
                'from' => $users->firstItem(),
                'perPage' => $users->perPage(),
                'to' => $users->lastPage(),
                'total' => $users->total(),
                'currentPage' => $users->currentPage(),
            ]);
    }

    /**
     * @param StoreRequest $request
     * @return void
     */
    public function store(StoreRequest $request)
    {
        $passwordGenerator = new ComputerPasswordGenerator();
        $passwordGenerator
            ->setUppercase()
            ->setLowercase()
            ->setNumbers()
            ->setLength(8);

        $password = $passwordGenerator->generatePassword();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'team_id' => auth()->user()->team_id,
        ]);

        if ($request->is_admin) {
            $user->attachRole('team-admin', $user->team);
        }

        Transaction::create([
            'user_id' => $user->id,
            'description' => 'Starting leave balance',
            'amount' => $request->balance,
        ]);

        try {
            Mail::to($user->email)->queue(new WelcomeEmail($user, $password));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return response()
            ->json([
                'message' => 'User created successfully',
                'user' => new UserResource($user),
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
                    'message' => 'You cannot view this user',
                ], 403);
        }

        if (!auth()->user()->hasRole('team-admin', $user->team)) {
            return response()
                ->json([
                    'message' => 'You cannot view this user',
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
                    'message' => "You cannot update this user",
                ], 403);
        }

        if ($request->is_admin) {
            $user->attachRole('team-admin', $user->team);
        } else {
            $user->detachRole('team-admin', $user->team);
        }
        $user->refresh();
        return response()
            ->json([
                'user' => new UserResource($user),
                'message' => "User role updated",
            ]);
    }
}
