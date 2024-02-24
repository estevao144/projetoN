<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tipoContaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_contas')->insert([
            'tipo_conta' => 'corrente',
            'taxa' => 0.00,
            'status' => 'ativo',
            'descricao' => 'Conta corrente'
        ]);

        DB::table('tipo_contas')->insert([
            'tipo_conta' => 'lojista',
            'taxa' => 0.05,
            'status' => 'ativo',
            'descricao' => 'Conta lojista'
        ]);
    }
}
