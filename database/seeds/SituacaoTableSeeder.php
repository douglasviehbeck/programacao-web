<?php

use App\Situacao;
use Illuminate\Database\Seeder;

class SituacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Situacao::create([
            'nome' => 'Nova',
        ]);

        Situacao::create([
            'nome' => 'Em andamento',
        ]);

        Situacao::create([
            'nome' => 'Em testes',
        ]);

        Situacao::create([
            'nome' => 'Fechada',
        ]);
    }
}
