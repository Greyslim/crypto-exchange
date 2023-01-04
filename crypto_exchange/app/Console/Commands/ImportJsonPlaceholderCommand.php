<?php

namespace App\Console\Commands;

use App\Components\ImportCryptoCompareData;
use Illuminate\Console\Command;

class ImportJsonPlaceholderCommand extends Command
{
    protected $signature = 'import:CryptoCompareJson';

    protected $description = 'Command description';

    public function handle()
    {
        $import = new ImportCryptoCompareData();
        $params = [
            'query' => [
               'fsyms' => 'BTC,USDT',
               'tsyms' => 'USDT,BTC',
            ]
         ];
        $response = $import->client->request('GET','pricemulti',$params);
        dd($response->getBody()->getContents());
    }
}
