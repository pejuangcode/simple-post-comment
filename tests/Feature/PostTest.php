<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class PostTest extends TestCase
{
      /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testIndex()
    {
        $post = Post::factory()->count(2)->create();
        Comment::factory()->count(3)->create(['post_id' => $post->random()->id ]);

        $this->get('/posts')
            ->assertStatus(302);
    }
    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testStore()
    {
        $params = $this->validParams();

        $this->actingAsUser()
            ->post(route('posts.store'), $params)
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    /**
     * Return error jika body empty
     *
     */
    public function test_store_show_error_if_body_empty()
    {
        $params = $this->validParams();
        $params['body'] =  null;

        $response = $this->actingAsUser()
            ->post(route('posts.store'), $params)
            ->assertStatus(302)
            ->assertRedirect('/');
            
        $response->assertSessionHasErrors('body', 'The body field is required.'); 
    }

    /**
     * Return error jika user_id tidak ada
     *
     */
    public function test_store_show_error_if_userid_is_empty()
    {
        $params = $this->validParams();
        $params['user_id'] =  null;

        $response = $this->actingAsUser()
            ->post(route('posts.store'), $params)
            ->assertStatus(302)
            ->assertRedirect('/');
            
        $response->assertSessionHasErrors('user_id', 'You dont have permission'); 
    }



    

    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testUpdate()
    {
        $post = Post::factory()->create();
        $params = $this->validParams();
        $params['id'] = $post->id;

        $this->actingAsUser()
            ->patch("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertRedirect('/');

            // $this->assertDatabaseHas('posts', $params);
            // $this->assertEquals($params['body'], $post->body);
    }

    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testEdit()
    {
        $post = Post::factory()->create();

        $this->actingAsUser()
            ->get("/posts/{$post->id}/edit")
            ->assertOk();
    }

        /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testDelete()
    {

        $post = Post::factory()->create();
        $comment = Comment::factory()
            ->count(2)
            ->create()
            ->each(function ($comment) use ($post) {
                $comment->post_id = $post->id;
                $comment->save();
            });

        $this->actingAsUser()
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertRedirect('/');

        $this->assertDatabaseMissing('posts', $post->toArray());
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'body' => "I'm a content",
            'user_id' => $this->randomUserId(),
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ], $overrides);
    }

}
