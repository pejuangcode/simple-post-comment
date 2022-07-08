<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::orderBy('id', 'DESC')->get();
         $posts = Post::with('user', 'comments', 'comments.replies',  'comments.user', 'comments.replies.user')
            ->orderBy('id', 'DESC')->get();

        return view('posts/index', compact('posts'));
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
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {

        DB::beginTransaction();   
        
        try {

            Post::create([
                'body' => $request->body,
                'user_id' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()
                    ->back()
                    ->with('success', 'Comment sent successfully');

        } catch(\Exception $e) {
            
            DB::rollBack();
            return redirect()
                    ->back()
                    ->with('error', 'Comment sent not successfully'); 
        }
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $Post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $Post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $Post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        DB::beginTransaction();   
        
        try {

            $post->body = $request->body;
            $post->save();

            DB::commit();
            return redirect()
                    ->back()
                    ->with('success', 'Update sent successfully');

        } catch(\Exception $e) {
            
            DB::rollBack();
            return redirect()
                    ->back()
                    ->with('error', 'Update sent not successfully'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $Post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();   
        
        try {

            $post->comments()->delete();
            $post->delete();
            DB::commit();

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
