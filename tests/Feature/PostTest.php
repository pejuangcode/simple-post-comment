<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

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
        $this->get('/posts')->assertStatus(302);
    }
    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testStore()
    {

        $params = ['body' => 'Selamat datang', 'user_id' =>  $this->randomUserId()];

        $this->actingAsUser()
            ->post(route('posts.store'), $params)
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testUpdate()
    {
        $post_id = Post::all()->random()->id;

        this->actingAsUser()
            ->patch("/posts/{$post_id}", ['body'=>'Its time '. now(),])
            ->assertStatus(302);

        $this->assertRedirect('/');
    }

    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testEdit()
    {
        $post_id = Post::all()->random()->id;

        $this->get("/posts/{$post_id}/edit")->assertStatus(302);
    }

        /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function testDelete()
    {
        $post_id = Post::all()->random()->id;

        $this->actingAsUser()
            ->delete("/posts/{$post_id}")
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    private function validParams($overrides = [])
    {
        $post = Post::factory()->create();

        return array_merge([
            'content' => 'Great article ! Thanks for sharing it with us.',
            'posted_at' => $post->posted_at->addDay()->format('Y-m-d\TH:i'),
            'post_id' => $post->id,
            'author_id' => User::factory()->create()->id,
        ], $overrides);
    }

}
