<?php

use App\Usuario;
use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'nome'     => 'Douglas Rafael Viehbeck',
            'username' => 'douglas',
            'password' => bcrypt('teste123'),
        ]);
    }
}
