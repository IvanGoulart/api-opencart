<?php

namespace App\Contracts\Magento;

interface PutContract
{
    const PUT = 'PUT';

    public function put($path, $id, $body, array $headers = []);
}
