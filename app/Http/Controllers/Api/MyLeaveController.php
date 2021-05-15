<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveResource;
use Illuminate\Http\Request;

class MyLeaveController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $leaves = auth()->user()->leaves()->paginate(10);

        return response()
            ->json(LeaveResource::collection($leaves));
    }
}
