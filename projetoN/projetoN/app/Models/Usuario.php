<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Usuario extends Model
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
        'conta',
    ];

    /**
     * Função criada para cadastrar um novo usuário.
     * @param array $dados
     * @return int|null
     */
    public static function cadastrarUsuario($dados)
    {
        $query = DB::insert(
            DB::raw("INSERT INTO usuarios (nome, cpf, email, senha, telefone, tipo_conta, conta, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"),
            [
                $dados['nome'],
                $dados['cpf'],
                $dados['email'],
                $dados['senha'],
                $dados['telefone'],
                $dados['tipo_conta'],
                $dados['conta'],
                Carbon::now(),
                Carbon::now()
            ]
        );
        if ($query) {
            return DB::getPdo()->lastInsertId(); // Tive que usar PDO para pegar o id do usuário cadastrado. Ele busca o ultimo id inserido.
        }
        return null;
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
    /**
     * Busca usuario pelo cpf.
     * @param string $cpf
     * @return object|null
     */
    public static function buscarUsuarioPorCpf($cpf)
    {
        $query = DB::select(DB::raw("SELECT * FROM usuarios WHERE cpf = '$cpf'"));
        return isset($query[0]) ? $query[0] : null;
    }
    /**
     * Função criada para vincular conta criada no cadastro do usuário.
     * @param int $idUsuario
     * @param int $idConta
     * @return void
     */
    public static function vincularConta($idUsuario, $idConta)
    {
        $query = DB::update(
            DB::raw("UPDATE usuarios SET conta = $idConta WHERE id = $idUsuario")
        );
    }
    /**
     * Função criada para validar se existe um usuário com o mesmo email.
     * @param string $email
     * @return array|null
     */
    public static function buscarUsuarioPorEmail($email)
    {
        $usuario = DB::select(DB::raw("SELECT * FROM usuarios WHERE email = '$email'"));
        return $usuario;
    }
    /**
     * Função criada para validar se existe um usuário com o mesmo telefone.
     * @param string $telefone
     * @return array|null
     */
    public static function buscarUsuarioPorTelefone($telefone)
    {
        $usuario = DB::select(DB::raw("SELECT * FROM usuarios WHERE telefone = '$telefone'"));

        return $usuario;
    }
}
