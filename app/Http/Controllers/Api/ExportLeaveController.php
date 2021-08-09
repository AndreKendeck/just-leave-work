<?php

namespace App\Http\Controllers\Api;

use App\Exports\LeaveExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExportLeaveController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($month = null, $year = null)
    {
        if (!auth()->user()->hasRole('team-admin', auth()->user()->team)) {
            return response()
                ->json([
                    'message' => 'You are not allowed to export leaves',
                ]);
        }

        $year = Carbon::create($year)->format('Y');
        $month = Carbon::create($month)->format('M');

        return Excel::download(new LeaveExport(auth()->user()->team->id, $month, $year), 'leaves.xlsx');
    }
}
