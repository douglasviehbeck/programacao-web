<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginValidoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->post('/', ['username' => 'douglas', 'password' => 'teste123']);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();
    }
}
