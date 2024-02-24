<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTransacaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_transacaos')->insert([
            'tipo_transacao' => 'deposito',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('tipo_transacaos')->insert([
            'tipo_transacao' => 'saque',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('tipo_transacaos')->insert([
            'tipo_transacao' => 'transferencia',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
