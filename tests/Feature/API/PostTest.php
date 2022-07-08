<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;


class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_posts_listed_successfully()
    {
        $params = ["body" => 'Its time '. now()];

        $this->actingAsUser('api')
            ->json('POST', 'api/posts', $params)
            ->assertOk()
            ->assertStatus(200);
    }

    public function test_post_can_be_created()
    {
        $params = ["body" => "Okey siap"];

        $this->actingAsUser('api')
            ->json('POST', '/api/posts', $params)
            ->assertStatus(200);

    }

    public function test_posts_can_be_updated()
    {
        
        $post = Post::factory()->create();

        $params = [
            "id" => $post->id,
            "body" => "Lorem Ipsum is simply dummy text of the printing and 
                        typesetting industry. Lorem Ipsum has been the industry's",
            "user_id" => $post->user_id,
        ];

        $this->actingAsUser('api')
            ->json('PATCH', 'api/posts/' . $post->id , $params)
            ->assertStatus(200);
    }

    public function test_posts_can_be_deleted()
    {
        $post = Post::factory()->create();

        $this->actingAsUser('api')
            ->json('DELETE', 'api/posts/' . $post->id, [])
            ->assertStatus(200)
            ->assertNoContent();
    }
}
