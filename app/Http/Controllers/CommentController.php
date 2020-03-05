<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Leave;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // not neeeded
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //not needed
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_id' => ['required' , Rule::exists('leaves', 'id')
            ->where('organization_id', auth()->user()->organization_id) ],
            'text' => ['required' , 'string' ]
        ]);
        $leave = Leave::findOrFail($request->leave_id);
        // check if the user owns the leave , can approve the leave or
        if (
        (auth()->user()->id == $leave->user_id)
        || (auth()->user()->hasPermission('approve-and-deny-leave', $leave->organization ))
        ) {
            $comment = Comment::create([
                'leave_id' => $request->leave_id,
                'text' => $request->text,
                'user_id' => auth()->user()->id
            ]);
            return response()->json([
                'comment' => $comment
            ]);
        }
        abort(403, "You are not allowed to perform this action");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //not needed
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //not needed
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => ['required' , 'string' ]
        ]);

        $comment = Comment::findOrFail($id);

        if ($comment->user_id != auth()->user()->id) {
            return response()->json([
                'errors' => [
                    'not_allowed' => ['You are not allowed to perform this action']
                ]
            ], 403);
        }
        $comment->update([
            'text' => $request->text
        ]);
        return response()->json([
            'comment' => $comment, 
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
        if ($comment->user_id != auth()->user()->id) {
            return response()->json([
                'errors' => [
                    'not_allowed' => ['You are not allowed to perform this action']
                ]
            ], 403 );
        }
        $comment->delete(); 
        return response()->json([
            'message' => 'Comment deleted succesfully'
        ]);
    }
}
