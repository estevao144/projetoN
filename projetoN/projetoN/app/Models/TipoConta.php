<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoConta extends Model
{
    use HasFactory;
    protected $table = 'tipo_contas';

    protected $fillable = [
        'tipo_conta',
        'taxa',
        'status',
        'descricao'
    ];

    /**
     * Função criada par busca de taxa de uma conta bancária.
     * @param string $conta
     * @return bool
     */
    public static function buscarTaxaConta($conta)
    {
        return self::select('taxa')->where('tipo_conta', $conta)->first();
    }

    /**
     * Busca e devolve o nome do tipo de conta.
     * @param string $conta
     * @return string
     */
    public static function buscarNomeConta($conta)
    {
        $query = DB::select(DB::raw("SELECT descricao FROM tipo_contas WHERE id = $conta"));
        
        return isset($query[0]) ? $query[0]->descricao : null;
    }

    /**
     * Buscar id da conta.
     * @param string $conta
     * @return int
     */
    public static function buscarIdConta($conta)
    {
        $query = DB::select(DB::raw("SELECT id FROM tipo_contas WHERE tipo_conta = '$conta'"));
        
        return isset($query[0]) ? $query[0]->id : null;
    }
}
