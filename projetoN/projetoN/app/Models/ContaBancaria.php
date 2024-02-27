<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
     * @param $idUsuario
     * @return int|null
     */
    public static function cadastrarContaBancaria($idUsuario)
    {
        $conta = rand(10000, 99999);
        $query = DB::insert(
            DB::raw("INSERT INTO conta_bancarias (agencia, conta, usuario, saldo, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, ?)"),
            [
                '0001', // Agência padrão '0001'
                $conta,
                $idUsuario,
                0,
                Carbon::now(),
                Carbon::now(),
            ]
        );
        
        if($query){
            return DB::getPdo()->lastInsertId();
        }
        return null;   
    }
    /**
     * Função criada para salvar controle de tentativas de transações.
     * @param int $idUsuario
     * @param int $tentativas
     * @return void
     */
    public static function atualizarTentativas($idUsuario, $tentativas)
    {
        DB::update(DB::raw("UPDATE conta_bancarias SET tentativas = $tentativas WHERE usuario = $idUsuario"));
    }
    /**
     * FUnção criada para bloquear conta do usuario devedor.
     * @param int $idDevedor
     */
    public static function bloquearConta($idDevedor)
    {
        DB::update(DB::raw("UPDATE conta_bancarias SET status = 'bloqueado' WHERE usuario = $idDevedor"));
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
        $query = DB::select(DB::raw("SELECT agencia, conta,status, tentativas, saldo  FROM conta_bancarias WHERE usuario = $usuarioId"));
        return isset($query[0]) ? $query[0] : null;
    }
    /**
     * Função para buscar valores de uma conta bancária.
     * @param int $id
     * @return object|null
     */
    public static function buscarSaldo($id)
    {
        $query = DB::select(DB::raw("SELECT saldo FROM conta_bancarias WHERE usuario = $id"));
        return isset($query[0]) ? $query[0]->saldo : null;
    }
}
