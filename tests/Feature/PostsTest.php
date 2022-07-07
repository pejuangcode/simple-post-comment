<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostsTest extends TestCase
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
        
        $data = ["body" => "Selamat datang"];
        $this->json('POST', 'api/posts', $data, ['Accept' => 'application/json'])->assertStatus(200);
    }

    public function test_post_can_be_created()
    {
        $this->actingAs(
            User::factory()->create(), 
        );

        $this->post('/api/posts')->assertStatus(200);

    }




}
