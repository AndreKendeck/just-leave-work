<?php

namespace App\Http\Controllers\Api;

use App\Exports\UserTransactionExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExportTransactionRequest;
use App\Jobs\DeleteExportFileFromStorage;
use Maatwebsite\Excel\Facades\Excel;

class ExportTransactionController extends Controller
{

    /**
     * @param ExportTransactionRequest $request
     * @param string $month
     * @param string $year
     * @return void
     */
    public function __invoke(ExportTransactionRequest $request, $user, $month = null, $year = null)
    {
        $user = \App\User::findOrFail($user);

        if (auth()->user()->team_id !== $user->team_id) {
            return response()
                ->json(['message' => "You cannot export this user's transactions."], 403);
        }

        $id = uniqid();
        // increment the month from the front end for the actual value
        $month++;

        $filename = "{$id}_transactions_{$month}_{$year}.xlsx";

        Excel::store(new UserTransactionExport($user->id, $month, $year), $filename, 'public');

        dispatch(new DeleteExportFileFromStorage($filename))->delay(now()->addMinutes(2));

        return response()
            ->json(['file' => asset($filename)]);
    }
}
