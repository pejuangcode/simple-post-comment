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
    public function test_posts_index()
    {
        Post::factory()->create();

        $this->actingAsUser('api')
            ->json('GET', '/api/posts')
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data" => [],
                "message"
            ]);
    }

    public function test_store_post()
    {
        $params = $this->validParams();
         
        $this->actingAsUser('api')
            ->json('POST', '/api/posts', $params)
            ->assertCreated()
            ->assertJsonStructure([
                "success",
                "data" => [
                    "id",
                    "body",
                    "created_at",
                    "updated_at",
                ],
                "message"
            ]);
    }

    public function test_posts_can_be_updated()
    {
        $post = Post::factory()->create();

        $params = [
            "id" => $post->id,
            "body" => "Lorem Ipsum is simply dummy text of the printing and",
            "user_id" => $post->user_id,
        ];

        $this->actingAsUser('api')
            ->json('PATCH', 'api/posts/' . $post->id , $params)
            ->assertOk();

        $post->refresh();
        $this->assertDatabaseHas('posts', $params);
        $this->assertEquals($params['body'], $post->body);
        $this->assertEquals($params['user_id'], $post->user_id);
    }

    public function test_posts_can_be_deleted()
    {
        $post = Post::factory()->create();

        $this->actingAsUser('api')
            ->json('DELETE', 'api/posts/' . $post->id, [])
            ->assertNoContent();
           
        $this->assertDatabaseMissing('posts', $post->toArray());
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'body' => 'Star Wars.',
            'user_id' => $this->randomUserId(),
        ], $overrides);
    }
}
