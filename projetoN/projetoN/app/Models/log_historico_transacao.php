<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class log_historico_transacao extends Model
{
    use HasFactory;

    protected $table = 'log_historico_transacoes';


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
    public static function cadastrarLogTransacao($dados)
    {
        return self::create($dados);
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
        FROM log_historico_transacoes
        WHERE id = $id");
    }
}
