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
        $this->actingAs(
            User::factory()->create(),
            'api'
        );
        
        $playload = ["body" => 'Its time '. now()];
        $this->json('POST', 'api/posts', $playload, ['Accept' => 'application/json'])->assertStatus(200);
    }

    public function test_post_can_be_created()
    {
        $this->actingAs(
            User::factory()->create(), 
            'api'
        );
        $playload = ["body" => "Okey siap"];
        $this->json('POST', '/api/posts', $playload, ['Accept' => 'application/json'])->assertStatus(200);

    }

    public function test_posts_can_be_updated()
    {
        $this->actingAs(
            User::factory()->create(),
            'api'
        );

        $post = Post::factory()->create();

        $playload = [
            "id" => $post->id,
            "body" => "Lorem Ipsum is simply dummy text of the printing and 
                        typesetting industry. Lorem Ipsum has been the industry's",
            "user_id" => $post->user_id,
        ];

        $this->json('PATCH', 'api/posts/' . $post->id , $playload, ['Accept' => 'application/json'])
            ->assertStatus(200);
            // ->assertJson([
            //     "success" => true,
            //     "data" => $playload,
            //     "message" => "Post updated successfully.",
            // ]);
    }

    public function test_posts_can_be_deleted()
    {
        $this->actingAs(
            User::factory()->create(),
            'api'
        );

        $post = Post::factory()->create();

        $this->json('DELETE', 'api/posts/' . $post->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
