<?php
     
namespace App\Http\Controllers\API;
     
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Post;
use Validator;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\DB;

     
class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user', 'comments', 'comments.replies',  'comments.user', 'comments.replies.user')
        ->orderBy('id', 'DESC')->get();
     
        $token = auth()->user()->token();
        $expiresDate = $token->expires_at;
        // $currentDate = now();
        // dd(now()->diff($expiresDate));

        return $this->sendResponse(PostResource::collection($posts), 'Post retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {

        DB::beginTransaction();   
        
        try {

            $post = Post::create([
                'body' => $request->body,
                'user_id' => auth()->user()->id,
            ]);
            DB::commit();
     
            return $this->sendResponse(new PostResource($post), 'Post created successfully.');

        } catch(\Exception $e) {
            
            DB::rollBack();
            return $this->sendError('Post not successfully.', 'Errr'); 
        }
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
    
        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }

        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
             
        DB::beginTransaction();   
        
        try {

            // $post = $post->update([
            //     'body' => $request->body,
            // ]);

            $post->body = $request->body;
            $post->save();
            DB::commit();

            return $this->sendResponse(new PostResource($post), 'Post updated successfully.');

        } catch(\Exception $e) {
            
            DB::rollBack();
            return $this->sendError('Post update not successfully.', 'Errr'); 
        }

    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        DB::beginTransaction();   
        
        try {

            $post->delete();
            DB::commit();

            return $this->sendResponse([], 'Post deleted successfully.');

        } catch(\Exception $e) {
            
            DB::rollBack();
            return $this->sendError('Post update not successfully.', 'Errr'); 
        }
     

    }
}