<?php

namespace App\Services;

use App\Models\TipoConta;
use App\Models\Usuario;
use App\Models\ContaBancaria;

class UsuarioService
{
    /**
     * Função para criar um usuário, validando se ja existe um usuário com o mesmo cpf, telefone ou email.
     * @param array $dados
     * @return array
     */
    public function criarUsuario($dados)
    {
        $this->validarUsuario($dados);
        $dados = $this->montarDadosUsuario($dados);
        $usuarioId = Usuario::cadastrarUsuario($dados);
        $contaBancariaId = ContaBancaria::cadastrarContaBancaria($usuarioId); // agora vinculo uma conta bancária ao usuário
        Usuario::vincularConta($usuarioId, $contaBancariaId); // agora atualizo o campo conta do usuário com o id da conta bancária
        return ['messagem' => 'Usuário cadastrado com sucesso.', 'id' => $usuarioId];
    }
    /**
     * Função utilizada para montar os dados do usuário para serem cadastrados.
     * @param array $dados
     * @return array
     */
    public function montarDadosUsuario($dados)
    {
        $statusPadrao = 1;
        $dadosUsuario = [
            'nome' => $dados['nome'],
            'cpf' => $dados['cpf'],
            'email' => $dados['email'],
            'senha' => $dados['senha'],
            'telefone' => $dados['telefone'],
            'tipo_conta' => TipoConta::buscarIdConta($dados['tipo_conta']),
            'status' => $statusPadrao,
            'conta' => null
        ];
        
        return $dadosUsuario;
    }
    /**
     * Função usada para buscar usuario pelo cpf.
     * @param array $dados
     * @return array|null
     */
    public function buscarUsuarioPorCpf($cpf)
    {
        $usuario = Usuario::buscarUsuarioPorCpf($cpf);
        if ($usuario != null) {
            return $this->tratarDadosUsuario($usuario);
        }
        throw new \Exception('Usuário não encontrado.', 404);
    }
    /**
     * Função utilizada para tratar os dados do usuário.
     * Devolvendo os dados de suas foreign keys, sem sua senha.
     * @param object $usuario
     * @return array
     */
    public function tratarDadosUsuario($usuario)
    {
        $tipoContas = TipoConta::buscarNomeConta($usuario->tipo_conta);
        $contaBancaria = ContaBancaria::buscarContaBancaria($usuario->id);

        $dadosUsuario = [
            'id' => $usuario->id,
            'nome' => $usuario->nome,
            'cpf' => $usuario->cpf,
            'email' => $usuario->email,
            'telefone' => $usuario->telefone,
            'tipo_conta' => $tipoContas,
            'conta_bancaria' => $contaBancaria,
            'status' => $usuario->status,
        ];

        return $dadosUsuario;
    }
    /**
     * Função utilizada para validação de usuário.
     * Se existe um usuário com o mesmo cpf, telefone ou email.
     * @param array $dados
     * @return void
     */
    public function validarUsuario($dados)
    {
        $usuario = Usuario::buscarUsuarioPorCpf($dados['cpf']);
        if ($usuario != null) {
            throw new \Exception('Já existe um usuário com esse cpf.', 400);
        }
        $usuario = Usuario::buscarUsuarioPorEmail($dados['email']);
        if ($usuario != null) {
            throw new \Exception('Já existe um usuário com esse email.', 400);
        }
        $usuario = Usuario::buscarUsuarioPorTelefone($dados['telefone']);
        if ($usuario != null) {
            throw new \Exception('Já existe um usuário com esse telefone.', 400);
        }
    }
}
