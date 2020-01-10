<?php

namespace App\Contracts\Magento;

interface ClientContract
{
    public function __construct(\GuzzleHttp\Client $client);
}
