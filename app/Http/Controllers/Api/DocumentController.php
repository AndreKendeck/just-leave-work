<?php

namespace App\Http\Controllers\Api;

use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

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
        if ($model->user_id !== auth()->user()->id) {
            return response()
                ->json([
                    'errors' => [
                        'documents' => ['You are not allowed to store documents on this request']
                    ]
                ], 403);
        }
        /** @var \Illuminate\Http\UploadedFile  */
        $uploadedFile = $request->document;
        $document = Document::create([
            'documentable_type' => $request->model,
            'documentable_id' => $request->id,
            'file_type' => $uploadedFile->getMimeType(),
            'size' => $uploadedFile->,
            'name' => $uploadedFile->hashName,
        ]);

        if ($document->id) {
            try {
                $uploadedFile->store(Document::STORAGE_PATH, 'public');
                return response()
                    ->json([
                        'message' => 'Document Upload Successsful'
                    ], 201);
            } catch (\Exception $e) {
                return response()
                    ->json([
                        'message' => 'Document could not be store'
                    ], 422);
            }
        }

        return response()
            ->json(['message' => 'Your file could not be uploaded'], 422);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        if ($document->documentable->user_id != auth()->user()->id) {
            return response()
                ->json([
                    'message' => 'You are not allowed to delete this document'
                ], 403);
        }
        $document->delete();
    }
}
