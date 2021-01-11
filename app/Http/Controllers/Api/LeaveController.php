<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\StoreRequest;
use App\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaves = Leave::where('team_id', auth()->user()->team_id)->latest()->paginate(10);

        return response()
            ->json($leaves);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $from = Carbon::create($request->from);
        $to = Carbon::create($request->until);

        $invalidDate = ($from > $to) || ($from === $to);

        if ($invalidDate) {
            return response()->json([
                'errors' => [
                    'from' => ['Your leave date is incorrect']
                ]
            ], 422);
        }

        $leave = Leave::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->id(),
            'reason_id' => $request->reason,
            'description' => $request->description,
            'from' => $from,
            'until' => $to,
        ]);

        return response()
            ->json([
                'message' => "Your leave request has been created successfully",
                'leave' => $leave
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
