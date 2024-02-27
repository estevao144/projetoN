<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class StatusTransacaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_transacao')->insert([
            'status' => 'aprovado',
            'descricao' => 'aprovado pelo sistema.'
        ]);

        DB::table('status_transacao')->insert([
            'status' => 'pendente',
            'descricao' => 'pendente de aprovacao.'
        ]);

        DB::table('status_transacao')->insert([
            'status' => 'recusado',
            'descricao' => 'Reprovado pelo sistema.'
        ]);
    }
}
