<?php

namespace App\Services;

use App\Services\ApiService;
use App\Models\log_historico_transacao as Transacao;

use App\Models\Usuarios;

class TransacaoService
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }
    /**
     * Método responsável por criar uma transação.
     * @param int $idCredor
     * @param int $idDevedor
     * @param float $valor
     * @return int
     */
    public function criarTransacao($idCredor, $idDevedor, $valor)
    {
        $this->validarTransacao($idCredor, $idDevedor, $valor);

        $transacao = Transacao::criarTransacao($idCredor, $idDevedor, $valor);

        $respostaBanco = $this->apiService->notificarTransacao();
        if ($respostaBanco) {
            $respostaNotificacao = $this->apiService->notificarTransacao();
            if ($respostaNotificacao) {
                return $transacao;
            }
        } else {
            $transacao->reverterTransacao($transacao->id);
            throw new \Exception('Houve um erro ao realizar a transação.');
        }
        return $transacao;
    }

    /**
     * Função criada para validar se transação é válida.
     * @param int $idCredor
     * @param int $idDevedor
     * @param float $valor
     * @return void
     */
    public function validarTransacao($idCredor, $idDevedor, $valor)
    {
        // primeiro valido se o devedor é uma loja
        $this->validarDevedor($idDevedor);
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
    public function validarDevedor($idDevedor)
    {
        $devedor = Usuarios::buscarUsuario($idDevedor);
        if ($devedor == null) {
            throw new \Exception('Devedor não encontrado.');
        }
        if ($devedor->tipo_conta != 1) {
            throw new \Exception('Devedor não é uma loja.');
        }
    }
    /**
     * Função criada para validar se credor existe no banco.
     * @param int $idCredor
     * @return void
     */
    public function validarCredor($idCredor)
    {
        $credor = Usuarios::buscarUsuario($idCredor);
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
        $credor = Usuarios::buscarUsuario($idCredor);
        if ($credor->saldo >= $valor) {
            return;
        }
        throw new \Exception('Saldo insuficiente.');
    }

    /**
     * Método responsável por buscar uma transação.
     * @param int $idTransacao
     * @return Transacao
     */
    public function buscarTransacao($idTransacao)
    {
        $transacao = Transacao::buscarTransacao($idTransacao);

        return $transacao;
    }
}
