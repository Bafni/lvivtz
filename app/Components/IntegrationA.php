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

    public function sendRequest(array $body)
    {
        $url = $_SERVER['SERVER_ADDR'] . '/api/' . $this->crm_uri;

        $response = $this->client->request('POST', $url, [
            'form_params' => $body,
        ]);

        return $response->getBody();
    }

    public function sendRequestWithApiKey( array $body)
    {
        $url = $_SERVER['SERVER_ADDR'] . '/api/' . $this->crm_uri;
        //так тут дубль кода для теста ))

        //Спроба емітації запиту авторизації для отриманная токена

        $response = $this->client->request('POST', $url, [
            'form_data' => $this->crmData($body), // Отримуємо токен на основі credentials
            'headers' => [
                'auth-me' => true
            ],
        ]);

        if ($response->getStatusCode() === 200 || $response->hasHeader('jwt_token')) {

            $this->mokJwt = $response->getHeaderLine('jwt_token');

            // Ніби у нас є токен і з токеном звертаємось до CRM

            $response = $this->client->request('POST', $url, [
                'form_data' => $this->crmData($body), // ну і нібито відправляємо данні після авторизації
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->mokJwt,
                ]
            ]);
        }
        //Тут можна вернути обєкт классу Response і у методах також
        return $response->getBody();
    }

}
