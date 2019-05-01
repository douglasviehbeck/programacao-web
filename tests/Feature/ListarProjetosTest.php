<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListarProjetosTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/projetos');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'nome',
                'criador',
            ]
        ]);
    }
}
