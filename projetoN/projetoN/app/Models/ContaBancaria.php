<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContaBancaria extends Model
{
    use HasFactory;

    protected $table = 'conta_bancarias';

    protected $fillable = [
        'agencia',
        'conta',
        'usuario',
        'status',
        'saldo',
    ];
    /**
     * Função criada para cadastrar uma nova conta bancária vinculada ao usuario.
     * @param array $dados
     * @return bool
     */
    public function cadastrarContaBancaria($dados)
    {
        return $this->create($dados);
    }

    /**
     * Função criada para retirar um valor da conta bancária e adicionar na conta do credor.
     * @param int $usuario
     * @param float $saldoAtual
     * @return void 
     */
    public static function depositarValor($usuario, $saldoAtual)
    {
        DB::update(DB::raw("UPDATE conta_bancarias SET saldo = $saldoAtual WHERE usuario = $usuario"));
    }
    /**
     * retirar valor da conta do devedor e adicionar na conta do credor.
     * @param int $usuario
     * @param float $saldoAtual
     * @return void 
     */
    public static function retirarValor($usuario, $saldoAtual)
    {
       DB::update(DB::raw("UPDATE conta_bancarias SET saldo = $saldoAtual WHERE usuario = $usuario"));
    }
    /**
     * Função criada para buscar conta bancária de um usuário.
     * @param int $usuarioId
     * @return object|null
     */
    public static function buscarContaBancaria($usuarioId)
    {
        $query = DB::select(DB::raw("SELECT * FROM conta_bancarias WHERE usuario = $usuarioId"));
        return isset($query[0]) ? $query[0] : null;
    }
    /**
     * Função para buscar valores de uma conta bancária.
     * @param int $id
     * @return object|null
     */
    public static function buscarSaldo($id)
    {
        $query = DB::select(DB::raw("SELECT saldo FROM conta_bancarias WHERE id = $id"));
        return isset($query[0]) ? $query[0]->saldo : null;
    }
}
