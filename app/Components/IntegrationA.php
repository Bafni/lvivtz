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

    public function sendRequest(array $body): object
    {
        $url = $_SERVER['SERVER_ADDR'] . '/api/' . $this->crm_uri;

        $response = $this->client->request('POST', $url, [
            'form_params' => $this->crmData($body),
        ]);

        return $response->getBody();
    }

    public function sendRequestWithApiKey(array $body, $token): object
    {
        $url = $_SERVER['SERVER_ADDR'] . '/api/' . $this->crm_uri;
        //так тут дубль кода для теста ))

        $response = $this->client->request('POST', $url, [
            'form_params' => $this->crmData($body), // CRM key:value
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        return $response->getBody();
    }

}
