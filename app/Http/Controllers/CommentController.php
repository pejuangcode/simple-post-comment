<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Support\Facades\DB;

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
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {

        DB::beginTransaction();   
        
        try {
            Comment::create([
                'body' => $request->body,
                'post_id' => $request->post_id,
                'parent_id' =>  $request->comment_id ?? null,
                'user_id' => auth()->user()->id,
            ]);
            DB::commit();

            return redirect()
                    ->back()
                    ->with('successfulComment', 'Comment sent successfully');

        } catch(\Exception $e) {
            
            DB::rollBack();
            return redirect()
                    ->back()
                    ->with('successfulComment', 'Comment sent successfully'); 
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        DB::beginTransaction();   
        
        try {
            
            if (! is_null($comment->replies())) 
                return $comment->replies()->delete();

            $comment->delete();
            DB::commit();

            // $result = parent::delete();

            return redirect()
                    ->back()
                    ->with('success', 'Data deleted successfully');

        } catch(\Exception $e) {
            
            DB::rollBack();
            return redirect()
                    ->back()
                    ->with('error', 'Data failed to delete'); 
        }
    }
}
