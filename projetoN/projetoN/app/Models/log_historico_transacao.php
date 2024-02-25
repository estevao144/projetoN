<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class log_historico_transacao extends Model
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
        INSERT INTO log_historico_transacao (devedor_id, credor_id, tipo_transacao, valor, status)
        VALUES (?,?,?,?,?)
        ");
        $valores = [
            $dados['devedor_id'],
            $dados['credor_id'],
            $dados['tipo_transacao'],
            $dados['valor'],
            $dados['status']
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
        return DB::raw("SELECT *
        FROM log_historico_transacao
        WHERE id = $id");
    }
}
