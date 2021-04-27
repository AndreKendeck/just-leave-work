<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ImportRequest;
use App\Imports\UserImport;
use Excel;

class ImportUserController extends Controller
{
    public function import(ImportRequest $request)
    {
        Excel::import(new UserImport, $request->users);

        return response()
            ->json([
                'message' => "Import in progress, you will be notified when its complete",
            ]);
    }
}
