<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

/**
 * @group Comments
 * @authenticated
 * APIs for adding comments to leaves
 */
class CommentController extends Controller
{

    /**
     * @bodyParam text string required for the content of the comment
     * @bodyParam leave_id required for the related model this commment belongs to
     * @bodyParam user_id requried for the related model that created this comment
     * @response {
     *  "id" : 1,
     *  "text" : "Example text",
     *  "user" : {},
     *  "leave" : {}
     * }
     * @param StoreRequest $request
     * @return void
     */
    public function store(StoreRequest $request)
    {
        $comment = Comment::create([
            'text' => $request->text,
            'leave_id' => $request->leave_id,
            'user_id' => auth()->id(),
        ]);

        return response()
            ->json([
                'message' => "Comment added successfully",
                'comment' => new CommentResource($comment),
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);

        $isInSameTeam = ($comment->user->team_id === auth()->user()->team_id);

        if (!$isInSameTeam) {
            return response()
                ->json([
                    'message' => "You are not allowed to view this comment",
                ], 403);
        }

        return response()
            ->json(new CommentResource($comment));
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

        if (!auth()->user()->owns($comment)) {
            return response()
                ->json([
                    'message' => "You are not allowed to update this comment",
                ], 403);
        }

        if (!$comment->is_editable) {
            return response()
                ->json([
                    'message' => "You can no longer update this comment",
                ], 403);
        }

        $comment->update([
            'text' => $request->text,
        ]);

        return response()
            ->json([
                'message' => "Comment updated successfully",
                'comment' => new CommentResource($comment),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (!auth()->user()->owns($comment)) {
            return response()
                ->json([
                    'message' => "You are not allowed to delete this comment",
                ], 403);
        }

        if (!$comment->is_deletable) {
            return response()
                ->json([
                    'message' => "You can no longer delete this comment",
                ], 403);
        }

        $comment->delete();

        return response()
            ->json([
                'message' => "Comment deleted",
            ]);
    }
}
