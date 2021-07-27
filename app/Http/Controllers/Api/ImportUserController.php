<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ImportRequest;
use App\Imports\UserImport;
use Excel;
use Exception;

class ImportUserController extends Controller
{
    public function import(ImportRequest $request)
    {
        try {
            $user = auth()->user();
            Excel::import(new UserImport($user->team_id , $user->id), $request->users);
        } catch (\Exception $e) {
            return response()->json([ 'message' => 'Something went wrong']); 
        }
        return response()
            ->json([
                'message' => "Import in progress, you will be notified when its complete",
            ]);
    }
}
