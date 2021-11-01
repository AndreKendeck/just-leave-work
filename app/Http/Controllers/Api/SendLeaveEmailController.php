<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveResource;
use Illuminate\Http\Request;

class SendLeaveEmailController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'email' => ['e-mail', 'required'],
        ], [
            'email.required' => 'Please enter your email address',
        ]);

        /** @var \App\Leave */
        $leave = \App\Leave::findOrFail($id);

        if ($leave->team_id != auth()->user()->team_id) {
            return response()
                ->json([
                    'message' => 'You are not allowed to to e-mail this leave',
                ], 403);
        }

        if (auth()->user()->owns($leave) && !auth()->user()->hasRole('team-admin', auth()->user()->team)) {
            $result = $leave->send($request->email);
            if (!$result) {
                return response()
                    ->json([
                        'message' => 'An error occured, please try again later',
                    ], 500);
            }
            return response()
                ->json([
                    'message' => 'Leave request e-mail',
                ]);
        }

        if (!auth()->user()->hasRole('team-admin' , auth()->user()->team)) {
            return response()
                ->json([
                    'message' => 'You are not allowed to e-mail leave',
                ], 403);
        }

        $result = $leave->send($request->email);
        if (!$result) {
            return response()
                ->json([
                    'message' => 'An error occured, please try again later',
                ], 500);
        }

        $leave = $leave->refresh();

        return response()
            ->json([
                'message' => 'Leave sent succesfully',
                'leave'=> new LeaveResource($leave)
            ]);
    }
}
