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
            ->json([
                'leaves' => LeaveResource::collection($leaves),
                'from' => $leaves->firstItem(),
                'perPage' => $leaves->perPage(),
                'to' => $leaves->lastPage(),
                'total' => $leaves->total(),
                'currentPage' => $leaves->currentPage()
            ]);
    }
}
