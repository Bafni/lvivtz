<?php


namespace App\Components;

use App\Http\Resources\Integration\IntergrationResource;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;

class IntegrationA extends Integration
{
    protected array $crm_keys = ['name_1', 'lastName_1', 'phone_1', 'email_1'];
    protected string $crm_uri = 'crm-a';
    protected string $mokJwt = '';

    public function sendRequest(array $headers, array $body)
    {
        $url = $_SERVER['SERVER_ADDR'] . '/api/' . $this->crm_uri;

        $response = $this->client->request('POST', $url, [
            'form_params' => $body,
            'headers' => $this->crmData($headers),
        ]);

        return $response->getBody();
    }

    public function sendRequestWithApiKey(array $headers, array $body)
    {
        $url = $_SERVER['SERVER_ADDR'] . '/api/' . $this->crm_uri;
        //так тут дубль кода для теста ))

        $response = $this->client->request('POST', $url, [

            'headers' => [
                $this->crmData($headers),
                'auth-me' => true
            ],
        ]);

        if ($response->getStatusCode() === 200 || $response->hasHeader('jwt_token')) {

            $this->mokJwt = $response->getHeaderLine('jwt_token');

            $response = $this->client->request('POST', $url, [
                'form_params' => $body,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->mokJwt,
                ]
            ]);
        }

        return $response->getBody();
    }

}
