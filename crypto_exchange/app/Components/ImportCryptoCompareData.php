<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportCryptoCompareData
{
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://min-api.cryptocompare.com/data/',
            'timeout' => '10',
            'headers' => [
                'Authorization' => "Bearer 642808033f1312023cd887678a78c85f3a9b27af290241b567a772bb7f52d48d"
            ],
            'verify' => false,
        ]);
    }
}