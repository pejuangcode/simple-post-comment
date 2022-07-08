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
    public function test_index_post()
    {
        $response = $this->get('/posts');

        $response->assertStatus(302);
    }
    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function test_store_post()
    {
        /**
        * Acting as berfungsi sebagai autentikasi, jika kita menghilangkannya maka akan error.
        */
        $response = $this->actingAs(User::factory()->create())
            ->post(route('posts.store'), [
                'body' => 'Selamat datang',
                'user_id' =>  User::all()->random()->id,
            ]);

        /**
        * Espektasi status 302, yang berarti redirect status code.
        */
        $response->assertStatus(302);

        /**
        * Espektasi bahwa setelah POST diarahkan ke posts.index
        */
        $response->assertRedirect('/');
    }

    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function test_update_post()
    {
        $post_id = Post::all()->random()->id;

        $response = $this->actingAs(User::factory()->create())
            ->patch("/posts/{$post_id}", [
                'body'=>'Its time '. now(),
            ]);
      
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function test_edit_post()
    {
        $post_id = Post::all()->random()->id;

        $response = $this->get("/posts/{$post_id}/edit");

        $response->assertStatus(302);
    }

        /**
     * A basic feature test example.
     *
     * @test
     * 
     */
    public function test_delete_post()
    {
        $post_id = Post::all()->random()->id;

        $response = $this->actingAs(User::factory()->create())
            ->post("/posts/{$post_id}",[
                '_method' => "DELETE"
            ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
