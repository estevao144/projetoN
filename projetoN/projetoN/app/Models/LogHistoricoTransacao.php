<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LogHistoricoTransacao extends Model
{
    use HasFactory;

    protected $table = 'log_historico_transacao';


    protected $fillable = [
        'devedor_id',
        'credor_id',
        'tipo_transacao',
        'valor',
        'status',
    ];

    /**
     * Função criada para cadastrar um novo log de transação.
     * @param array $dados
     * @return bool
     */
    public static function criarTransacao($dados)
    {
        $query = DB::raw("
        INSERT INTO log_historico_transacao (devedor_id, credor_id, tipo_transacao, valor, status, created_at, updated_at)
        VALUES (?,?,?,?,?,?,?)
        ");
        $valores = [
            $dados['devedor_id'],
            $dados['credor_id'],
            $dados['tipo_transacao'],
            $dados['valor'],
            $dados['status'],
            $dados['created_at'],
            $dados['updated_at'],

        ];

        return DB::insert($query, $valores);
    }

    /**
     * Função criada para listar todos os logs de transações.
     * @return array
     */
    public static function listarLogsTransacoes()
    {
        return self::all();
    }

    /**
     * Função criada para listar todos os logs de transações de um usuário.
     * @param int $usuarioId
     * @return array
     */
    public static function listarLogsTransacoesUsuario($usuarioId)
    {
        return self::where('devedor_id', $usuarioId)
            ->orWhere('credor_id', $usuarioId)->get();
    }
    /**
     * Função criada para lista log especifico de transação.
     * @param string $id
     * @return object
     */
    public static function buscarTransacao($id)
    {
        $query = DB::raw("SELECT *
        FROM log_historico_transacao
        WHERE id = $id");

        return DB::select($query)[0];
    }

    /**
     * Função para atualizar status de uma transação revertida.
     * @param string $id
     * @return bool
     */
    public static function atualizarTransacao($id, $dados)
    {
        $query = DB::raw("UPDATE log_historico_transacao SET status = ?, updated_at = ? WHERE id = ?");
        $valores = [
            $dados['status'],
            $dados['updated_at'],
            $id
        ];
        return DB::update($query, $valores);
    }
}
