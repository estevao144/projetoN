<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoContaSeed extends Seeder
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
            'status' => 1,
            'descricao' => 'Conta corrente'
        ]);

        DB::table('tipo_contas')->insert([
            'tipo_conta' => 'lojista',
            'taxa' => 0.05,
            'status' => 1,
            'descricao' => 'Conta lojista'
        ]);
    }
}
