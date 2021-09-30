<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreRequest;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function store(StoreRequest $request)
    {
        $model = null;

        switch ($request->model) {
            case 'leave':
                $model = \App\Leave::findOrFail($request->id);
                break;
            case 'comment':
                $model = \App\Comment::findOrFail($request->id);
                break;
        }
        
        if ($model->user_id !== auth()->id()) {
            return response()
                ->json([
                    'errors' => [
                        'documents' => ['You are not allowed to store documents on this request']
                    ]
                ]);
        }
    }

    public function destroy($id)
    {
    }
}
