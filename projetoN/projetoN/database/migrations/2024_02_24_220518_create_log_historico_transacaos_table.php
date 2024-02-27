<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogHistoricoTransacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_historico_transacaos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('devedor_id')->constrained('usuarios');
            $table->foreignId('credor_id')->constrained('usuarios');
            $table->foreignId('status')->constrained('status_transacao');
            $table->decimal('valor', 10, 2);
            $table->timestamps();

            $table->index('devedor_id');
            $table->index('credor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_historico_transacaos');
    }
}
