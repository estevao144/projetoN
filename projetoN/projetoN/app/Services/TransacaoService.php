<?php

namespace App\Services;

use App\Services\ApiService;
use App\Services\UsuarioService;
use App\Models\ContaBancaria as ContaBancaria;
use App\Models\LogHistoricoTransacao as Transacao;
use App\Models\Usuario;
use Carbon\Carbon;

class TransacaoService
{
    protected $apiService;
    protected $usuarioService;

    public function __construct(ApiService $apiService, UsuarioService $usuarioService)
    {
        $this->apiService = $apiService;
        $this->usuarioService = $usuarioService;
    }
    /**
     * Método responsável por criar uma transação.
     * @param int $idCredor
     * @param int $idDevedor
     * @param float $valor
     * @return array
     */
    public function criarTransacao($idCredor, $idDevedor, $valor, $password)
    {
        $this->validarTransacao($idCredor, $idDevedor, $valor, $password);

        $transacao = $this->salvarTransacao($idCredor, $idDevedor, $valor);

        return $transacao;
    }
    /**
     * Função criada para validar se transação é válida.
     * @param int $idCredor
     * @param int $idDevedor
     * @param float $valor
     * @param string $password
     * @return void
     */
    public function validarTransacao($idCredor, $idDevedor, $valor, $password)
    {
        // primeiro valido se o devedor é uma loja
        $this->validarDevedor($idDevedor, $password);
        // valido se o credor é uma pessoa
        $this->validarCredor($idCredor);
        // valido se o valor é maior que 0
        $this->validarValor($idCredor, $valor);
    }

    /**
     * Método responsável por validar se o devedor é uma loja.
     * @param int $idDevedor
     * @return void
     */
    public function validarDevedor($idDevedor, $password)
    {
        $devedor = Usuario::buscarUsuario($idDevedor);
        if ($devedor == null) {
            throw new \Exception('Usuario não encontrado.');
        }
        if ($devedor->tipo_conta != 1) {
            throw new \Exception('Operação negada para tipo de conta.');
        }
        $conta = ContaBancaria::buscarContaBancaria($idDevedor);
        if ($conta->status != 'ativo') {
            throw new \Exception('Conta bloqueada, contate o suporte.');
        }
        if(session('tentativas') == 0 || session('tentativas') == null){
            session(['tentativas' => 0]);
        }

        $senhaUsuario = $this->usuarioService->decodificarSenha($devedor->senha);
        if ($senhaUsuario != $password) {
            $tentativas = $conta->tentativas + 1;
            ContaBancaria::atualizarTentativas($idDevedor, $tentativas);
            if ($tentativas > 2) {
                ContaBancaria::bloquearConta($idDevedor);
                throw new \Exception('Conta bloqueada, contate o suporte.');
            }
            throw new \Exception('Senha inválida. Você tem mais ' . (3 - $tentativas) . ' tentativas.');
        } else {
            session(['tentativas' => 0]);
        }
    }
    /**
     * Função criada para validar se credor existe no banco.
     * @param int $idCredor
     * @return void
     */
    public function validarCredor($idCredor)
    {
        $credor = Usuario::buscarUsuario($idCredor);
        if ($credor == null) {
            throw new \Exception('Credor não encontrado.');
        }
    }

    /**
     * Função criada para validar valores disponiveis.
     * @param int $idCredor
     * @param float $valor
     * @return void
     */
    public function validarValor($idCredor, $valor)
    {
        $valorDisponivel = ContaBancaria::buscarSaldo($idCredor);
        if ($valorDisponivel >= $valor) {
            return;
        }
        throw new \Exception('Saldo insuficiente.');
    }
    /**
     * Função criada para retirar valor da conta do devedor e adicionar na conta do credor.
     * @param int $idCredor
     * @param int $idDevedor
     * @param float $valor
     * @return array
     */
    public function salvarTransacao($idCredor, $idDevedor, $valor)
    {
        $respostaBanco = $this->apiService->autorizarTransacao();
        if ($respostaBanco) {
            $this->retirarValorConta($idDevedor, $valor);
            $this->adicionarValorConta($idCredor, $valor);
            // salvar transação no banco
            $dados = [
                'devedor_id' => $idDevedor,
                'credor_id' => $idCredor,
                'valor' => $valor,
                'status' => 1, // 1 = transação realizada
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $transacao = Transacao::criarTransacao($dados);
            if ($transacao) {
                $this->apiService->notificarTransacao();
                return ['mensagem' => 'Transação realizada com sucesso.', 'status' => 200];
            }
        } else {
            $dados = [
                'devedor_id' => $idDevedor,
                'credor_id' => $idCredor,
                'valor' => $valor,
                'status' => 3, // 3 = transação recusada
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $transacao = Transacao::criarTransacao($dados);
            if ($transacao) {
                return ['mensagem' => 'Transação recusada.', 'status' => 400];
            }
        }

        throw new \Exception('Houve um erro ao realizar a transação.');
    }
    /**
     * Função criada para adicionar valor na conta do credor.
     * @param int $idCredor
     * @param float $valor
     * @return void
     */
    public function adicionarValorConta($idCredor, $valor)
    {
        $saldo = ContaBancaria::buscarSaldo($idCredor);
        $valorAtual = $saldo + $valor;
        ContaBancaria::depositarValor($idCredor, $valorAtual);
    }
    /**
     * Função criada para retirar valor da conta do devedor.
     * @param int $idDevedor
     * @param float $valor
     * @return void
     */
    public function retirarValorConta($idDevedor, $valor)
    {
        $saldo = ContaBancaria::buscarSaldo($idDevedor);
        $valorAtual = $saldo - $valor;
        if ($valorAtual < 0) {
            throw new \Exception('Saldo insuficiente.');
        }
        ContaBancaria::retirarValor($idDevedor, $valorAtual);
    }
    /**
     * Método responsável por buscar uma transação.
     * @param int $idTransacao
     * @return object
     */
    public function buscarTransacao($idTransacao)
    {
        $transacao = Transacao::buscarTransacao($idTransacao);

        return $transacao;
    }

    /**
     * Método responsável por reverter uma transação.
     * @param int $idTransacao
     * @return array
     */
    public function reverterTransacao($idTransacao)
    {
        $transacao = $this->buscarTransacao($idTransacao);
        switch ($transacao->status) {
            case null:
                throw new \Exception('Transação não encontrada.');
            case 2:
                throw new \Exception('Transação já foi revertida.');
            case 3:
                throw new \Exception('Transação já se encontra bloqueada.');
            default:
                return $this->reverterTransacaoBanco($transacao);
        }
    }
    /**
     * Função criada para reverter transação no banco.
     * @param $transacao
     * @return array
     */
    public function reverterTransacaoBanco($transacao)
    {
        $autorizacao = $this->validarReversao($transacao);
        if ($autorizacao) {
            $dados = [
                'status' => 2,
                'updated_at' => Carbon::now()
            ];
            // primeiro eu estorno o valor da conta do credor.
            $this->retirarValorConta($transacao->credor_id, $transacao->valor);
            // envio o valor para a conta do devedor.
            $this->adicionarValorConta($transacao->devedor_id, $transacao->valor);
            $transacao = Transacao::atualizarTransacao($transacao->id, $dados);
            if ($transacao) {
                $this->apiService->notificarTransacao();
                return ['mensagem' => 'Transação revertida com sucesso.', 'status' => 200];
            }
        }
        throw new \Exception('Houve um erro ao reverter a transação.');
    }
    /**
     * Função criada para validar se transação pode ser revertida.
     * @param Transacao $transacao
     * @return bool
     */
    public function validarReversao($transacao)
    {
        if ($transacao->status != 1) {
            throw new \Exception('Transação de reversão não pode ser revertida.');
        }
        return $this->apiService->autorizarTransacao();
    }
}
