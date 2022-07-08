<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HTTPTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('api/getdata');
        $response->assertJson(['website'=>'Pundi Mas Berjaya']);
    }

    /**
     * do a test for route '/'
     *
     * @return void
     */
    public function testView()
    {
      $response = $this->get('/');

      $response->assertViewIs('app');
    }

     /**
     * Testing status from url
     *
     * @return void
     */
    public function testStatusCode()
    {
        $response = $this->get('api/status');

        $response->assertStatus(404);
    }

}
