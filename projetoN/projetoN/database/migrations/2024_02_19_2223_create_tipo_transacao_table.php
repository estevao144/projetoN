<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Database\Seeders\TipoTransacaoSeed;




class CreateTipoTransacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_transacaos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_transacao'); // deposito, saque, transferencia
            $table->timestamps();
        });

        // Adicionar a seed para popular
        $TipoTransacaoSeed = new TipoTransacaoSeed();
        $TipoTransacaoSeed->run();
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_transacaos');
    }
}
