<?php

namespace App\Http\Services\Magento;

use App\Contracts\Magento\ClientContract;

class MagentoClient implements ClientContract
{

  /**
   * Client HTTP
   *
   * @var GuzzleHttp\Client
   */
    protected $client;

    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get client HTTP
     *
     * @return  GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set client HTTP
     *
     * @param  GuzzleHttp\Client  $client  Client HTTP
     *
     * @return  self
     */
    public function setClient(\GuzzleHttp\Client $client)
    {
        $this->client = $client;

        return $this;
    }
}
