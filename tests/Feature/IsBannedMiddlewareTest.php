<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class IsBannedMiddlewareTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_is_banned_show_error()
    {
        $userIsBanned = User::factory()->create(['is_banned' => 1]);
      
        $this->actingAs($userIsBanned)
             ->get('/posts')
             ->assertForbidden();
    }

    /** @test */
    public function test_can_be_accessed_if_user_is_not_banned(): void
    {
        $isNotBanned = User::factory()->create(['is_banned' => 0]);

        $this->actingAs($isNotBanned)
          ->get('/posts')
          ->assertOk();
    }
}
