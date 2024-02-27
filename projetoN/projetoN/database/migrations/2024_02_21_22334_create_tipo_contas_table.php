<?php

use Database\Seeders\TipoContaSeed;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\TipoTransacaoSeed;
class CreateTipoContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_contas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_conta'); // corrente, lojista
            $table->decimal('taxa', 10, 2); // taxa de operacao
            $table->string('descricao'); // descricao do tipo de conta
            $table->timestamps();

            $table->index('tipo_conta');
            
        });
        $TipoTransacaoSeed = new TipoContaSeed();
        $TipoTransacaoSeed->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_contas');
    }
}
