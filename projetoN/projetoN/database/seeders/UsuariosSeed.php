<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'nome' => 'Fulano de Tal',
            'cpf' => '12345678901',
            'email' => 'fulano@gmail.com',
            'senha' => '123456',
            'telefone' => '123456789',
            'tipo_conta' => 1,
            'status' => 1,
            'conta' => 1,
        ]);

        DB::table('usuarios')->insert([
            'nome' => 'Ciclano de Tal',
            'cpf' => '10987654321',
            'email' => 'cilano@yahoo.com',
            'senha' => '654321',
            'telefone' => '987654321',
            'tipo_conta' => 1,
            'status' => 1,
            'conta' => 2,
        ]);

        DB::table('usuarios')->insert([
            'nome' => 'Francisco Souza',
            'cpf' => '65987451230',
            'email' => 'xicoLojista@live.com',
            'senha' => '123456',
            'telefone' => '987456321',
            'tipo_conta' => 2,
            'status' => 1,
            'conta' => 3,
        ]);
    }
}
