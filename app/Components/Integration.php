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
    final public function crmData($values, $keys) : array {

        $values = array_values($values);

        return array_combine($keys, $values);
    }

    abstract public function sendRequest(array $body) ;
    abstract public function sendRequestWithApiKey(array $body);
}
