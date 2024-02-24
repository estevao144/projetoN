<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class statusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'status' => 'ativo',
            'descricao' => 'Status de conta ativa',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('status')->insert([
            'status' => 'inativo',
            'descricao' => 'Status de conta inativa',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('status')->insert([
            'status' => 'bloqueado',
            'descricao' => 'Status de conta bloqueada',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
