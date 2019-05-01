<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalvarProjetoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->withHeader('Vuelidation', 'unit-test')->post('/', ['username' => 'douglas', 'password' => 'teste123']);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();

        $response = $this->post('/projetos/salvar', [
            'nome'      => md5(rand()),
            'descricao' => 'teste unitário descricao',
        ]);

        $response->assertJsonStructure(['projetoId', 'nome', 'descricao']);
    }
}
