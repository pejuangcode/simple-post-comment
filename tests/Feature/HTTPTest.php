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
        $this->get('api/getdata');
        $this->assertJson(['website'=>'Pundi Mas Berjaya']);
    }

    /**
     * do a test for route '/'
     *
     * @return void
     */
    public function testView()
    {
       $this->get('/')->assertViewIs('app');
    }

     /**
     * Testing status from url
     *
     * @return void
     */
    public function testStatusCode()
    {
        $this->get('api/status')->assertStatus(404);
    }

}
