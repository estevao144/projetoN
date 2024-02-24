<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conta_bancaria extends Model
{
    use HasFactory;

    protected $table = 'conta_bancarias';

    protected $fillable = [
        'agencia',
        'conta',
        'usuario_id',
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
     * Função criada para depositar um valor na conta bancária.
     * @param int $valor
     * @return bool
     */
    public function depositar($valor)
    {
        $this->saldo += $valor;
        return $this->save();
    }
}
