<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'senha',
        'telefone',
        'tipo_conta',
        'status',
    ];

    /**
     * Função criada para cadastrar um novo usuário.
     * @param array $dados
     * @return bool
     */
    public function cadastrarUsuario($dados)
    {
        return $this->create($dados);
    }
}
