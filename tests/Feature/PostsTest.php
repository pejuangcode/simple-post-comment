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


    public function it_returns_an_author_as_a_resource_object()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $data = [ "body" => "Selamat datang"];
        $this->json('POST', 'api/posts', $data, ['Accept' => 'application/json'])->assertStatus(200);
    }
}
