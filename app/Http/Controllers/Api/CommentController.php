<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\DestroyRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $comment = Comment::create([
            'leave_id' => $request->leave_id,
            'user_id' => auth()->user()->id,
            'text' => $request->text
        ]);
        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if (!$comment->can_edit) {
            abort(403, "You cannot perform this action");
        }
        if (!$comment->is_editable) {
            return response()->json([
                'errors' => ['You can no longer edit this comment']
            ], 422);
        }
        $comment->update(['text' => $request->text ]);
        return response()
        ->json([
            'message' => 'Comment has been updated',
            'comment' => $comment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        
        if (!$comment->can_edit) {
            abort(403, "You cannot perform this action");
        }
        if (!$comment->is_deletable) {
            return response()->json([
                'errors' => ['You can no longer delete this comment']
            ], 422);
        }
        $comment->delete();
        return response()
        ->json([
            'message' => 'Comment has deleted'
        ]);
    }
}
