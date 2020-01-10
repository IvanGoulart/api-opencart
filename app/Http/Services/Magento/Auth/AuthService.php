<?php

namespace App\Http\Services\Magento\Auth;

use App\Contracts\Magento\ClientContract;
use App\Contracts\Magento\PostContract;

class AuthService implements PostContract
{
    private $client;

    public function __construct(ClientContract $client)
    {
        /** @var a $client */
        $this->client = $client->getClient();
    }

    /**
     * Consulta a API do Magento e obtem o JSON de autenticação
     *
     * @param $path
     * @param array $data
     * @return void
     */
    public function post($path, $data, array $headers = [])
    {
        $response = $this->client->request(self::POST, $path, [
            'json' => $data
        ]);

        // Converte a resposta em objeto
        $token = json_decode($response->getBody()->getContents());

        return $token;
    }
}
