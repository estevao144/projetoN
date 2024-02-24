<?php

namespace App\Services\mockAPIExterna;

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $urlAutorizacao;
    protected $clientHttp;
    protected $urlNotificacao;
    public function __construct()
    {
        $this->urlAutorizacao = config('custom.URL_AUTORIZACAO');
        $this->urlNotificacao = config('custom.URL_NOTIFICACAO');
        $this->iniciarClientHttp();
    }

    public function iniciarClientHttp()
    {
        $this->clientHttp = Http::withHeaders([
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Método responsável por realizar a autorização de uma transação.
     */
    public function autorizarTransacao()
    {
        $response = $this->clientHttp->post($this->urlAutorizacao);
        return $response->json();
    }

    /**
     * Método responsável por realizar a notificação de uma transação.
     */
    public function notificarTransacao()
    {
        $response = $this->clientHttp->post($this->urlNotificacao);
        return $response->json();
    }
}
