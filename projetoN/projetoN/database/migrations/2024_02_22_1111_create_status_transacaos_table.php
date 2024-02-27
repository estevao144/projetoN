<?php

use Database\Seeders\StatusTransacaoSeed;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTransacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_transacao', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('descricao');
            $table->timestamps();
        });

        $TipoTransacaoSeed = new StatusTransacaoSeed();
        $TipoTransacaoSeed->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_transacao');
    }
}
