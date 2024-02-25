<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ContasBancariasSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conta_bancarias')->insert([
            'conta' => '123456-7',
            'usuario' => 1,
            'status' => 1,
            'saldo' => 1000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('conta_bancarias')->insert([
            'conta' => '765432-1',
            'usuario' => 2,
            'status' => 1,
            'saldo' => 1000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('conta_bancarias')->insert([
            'conta' => '987654-3',
            'usuario' => 3,
            'status' => 1,
            'saldo' => 5000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
