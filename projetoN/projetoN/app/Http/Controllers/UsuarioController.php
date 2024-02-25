<?php

namespace App\Http\Controllers;

use App\Services\UsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private $UsuarioService;

    public function __construct(UsuarioService $UsuarioService)
    {
        $this->UsuarioService = $UsuarioService;
    }
    public function criarUsuario(Request $request)
    {
        $response =  $this->UsuarioService->criarUsuario($request->all());
        return response()->json($response, 201);
    }

    public function buscarUsuarioPorCpf($cpf)
    {
        $usuario = $this->UsuarioService->buscarUsuarioPorCpf($cpf);
        return response()->json($usuario, 200);
    }
}
