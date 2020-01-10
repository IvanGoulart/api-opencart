<?php

namespace App\Contracts\Magento;

interface GetContract
{
    const GET = 'GET';

    public function get($path, $id, array $data = [], array $headers = []);
}
