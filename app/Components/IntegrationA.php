<?php


namespace App\Components;

use App\Http\Resources\Integration\IntergrationResource;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;

class IntegrationA extends Integration
{
    protected array $crm_keys = ['nameCrm', 'lastNameCrm', 'phoneCrm', 'emailCrm'];
    protected string $crm_uri = 'crm-a';
    protected string $mokJwt = '';

    public function sendRequest(array $body): object
    {
        $url = $_SERVER['SERVER_ADDR'] . '/api/' . $this->crm_uri;

        $response = $this->client->request('POST', $url, [
            'form_params' => $this->crmData($body, $this->crm_keys), // CRM key:value
        ]);

        return $response->getBody();
    }

    public function sendRequestWithApiKey(array $body): object
    {
        $url = $_SERVER['SERVER_ADDR'] . '/api/' . $this->crm_uri;
        //так тут дубль кода для теста ))
        $password = $body['password'];
        unset($body['password']);
        $response = $this->client->request('POST', $url, [

            'headers' => [
                'nameCrm' => $body['name'],
                'passwordCrm' => $password,
            ],
        ]);
        if($response->hasHeader('api_key')) {
            $response = $this->client->request('POST', $url, [
                'form_params' => $this->crmData($body, $this->crm_keys),
                'headers' => [
                     'Authorization' => 'Bearer ' .$response->getHeader('api_key')[0],
                ]]);
        }

        return $response->getBody();
    }

}
