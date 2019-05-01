<?php

namespace Tests\Feature;

use App\Projeto;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletarProjetoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $projeto = Projeto::create([
            'nome'      => md5(rand()),
            'descricao' => md5(rand()),
            'usuarioId' => 1,
        ]);

        $response = $this->post('/projetos/deletar/' . $projeto->projetoId);

        $response->assertJson([
            'success' => true,
        ]);
    }
}
