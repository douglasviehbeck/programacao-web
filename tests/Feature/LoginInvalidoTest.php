<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginInvalidoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->post('/', ['username' => 'invalid_login', 'password' => 'invalid_password']);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['loginError']);

        $response = $this->post('/', ['username' => 'invalid_login']);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['password']);

        $response = $this->post('/', ['password' => 'invalid_password']);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['username']);
    }
}
