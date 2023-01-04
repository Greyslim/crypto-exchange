<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportCryptoCompareData
{
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('CRYPTO_COMPARE_URL') . '/data/',
            'timeout' => '10',
            'headers' => [
                'Authorization' => "Bearer " . env('CRYPTO_COMPARE_URL_TOKEN')
            ],
            'verify' => false,
        ]);
    }
}