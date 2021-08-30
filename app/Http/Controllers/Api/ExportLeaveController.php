<?php

namespace App\Http\Controllers\Api;

use App\Exports\LeaveExport;
use App\Http\Controllers\Controller;
use App\Jobs\DeleteLeaveExportFromStorage;
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
                ], 403);
        }

        $id = uniqid();
        // increment the month from the front end for the actual value
        $month++;
        
        Excel::store(new LeaveExport(auth()->user()->team->id, $month, $year), "{$id}_leaves_{$month}_{$year}.xlsx", 'public');

        dispatch(new DeleteLeaveExportFromStorage("{$id}_leaves_{$month}_{$year}.xlsx"))->delay(now()->addMinutes(2));

        return response()
            ->json([
                'message' => 'Export successfull',
                'file' => asset("/storage/{$id}_leaves_{$month}_{$year}.xlsx"),
            ]);
    }
}
