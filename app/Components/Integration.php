<?php


namespace App\Components;


use GuzzleHttp\Client;

abstract class Integration
{
    protected Client $client;

    protected array $crm_keys;

    public function __construct()
    {
        $this->client = new Client([
            'timeout'  => 2.0,
        ]);
    }
    final public function crmData($data) : array {

        $values = array_values($data);

        return array_combine($this->crm_keys, $values);
    }

    abstract public function sendRequest(array $headers, array $body) ;
    abstract public function sendRequestWithApiKey(array $headers, array $body);
}
