<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Return an user
     *
     * @return User
     */
    protected function user($overrides = [])
    {
        return User::factory()->create($overrides);
    }

    /**
     * Acting as an user
     */
    protected function actingAsUser($api = null)
    {
        $this->actingAs($this->user(), $api);

        return $this;
    }

    protected function randomUserId()
    {
        return User::all()->random()->id;
    }
}
