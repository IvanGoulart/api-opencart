<?php

namespace App\Contracts\Magento;

interface PostContract
{
    const POST = 'POST';

    public function post($path, $body, array $headers = []);
}
