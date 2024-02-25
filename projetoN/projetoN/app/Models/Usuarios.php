<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return DB::table($this->table)->insert($dados);
    }

    /**
     * Função criada para buscar um usuário.
     * @param int $id
     * @return object|null
     */
    public static function buscarUsuario($id)
    {
        $query = DB::select(DB::raw("SELECT * FROM usuarios WHERE id = $id"));
        return isset($query[0]) ? $query[0] : null;
    }
}
