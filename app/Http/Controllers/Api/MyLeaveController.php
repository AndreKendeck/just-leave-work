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
        /** @var \Illuminate\Pagination\LengthAwarePaginator $leaves */
        $leaves = auth()->user()->leaves()->paginate(10);

        return response()
            ->json(
                ['leaves' => LeaveResource::collection($leaves),
                    'from' => $leaves->firstItem(), 'to' => $leaves->lastItem() , 'firs'=> $leaves->url(1) ]
            );
    }
}
