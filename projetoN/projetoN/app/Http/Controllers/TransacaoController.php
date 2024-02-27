<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransacaoService;

class TransacaoController extends Controller
{
    protected $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }


    /**
     * Enpoint criado para criar uma transação.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function criarTransacao(Request $request)
    {
        $idCredor = $request->payee;
        $idDevedor = $request->payer;
        $valor = $request->value;
        $password = $request->password;

        $transacao = $this->transacaoService->criarTransacao($idCredor, $idDevedor, $valor, $password);
        return response()->json($transacao['mensagem'], $transacao['status']);
    }

    /**
     * Enpoint criado para rever transação.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reverterTransacao(Request $request)
    {
        $idTransacao = $request->id;
        $transacao = $this->transacaoService->reverterTransacao($idTransacao);
        return response()->json($transacao);
    }
}
