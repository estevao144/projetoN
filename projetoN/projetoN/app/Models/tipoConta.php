<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoConta extends Model
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
}
