<?php

namespace App\Http\Services\Magento\Products;

use App\Contracts\Magento\ClientContract;
use App\Contracts\Magento\PostContract;
use App\Contracts\Magento\PutContract;
use App\Contracts\Magento\GetContract;
use App\Libraries\Magento\Utils\SearchCriteria;

class ProductService implements PostContract, PutContract, GetContract
{
  private $client;

  public function __construct(ClientContract $client)
  {
    /** @var a $client */
    $this->client = $client->getClient();
  }

  /**
   * Integra Produto Magento
   * @param $path
   * @param array $data
   * @return void
   */
  public function post($path, $data, array $headers = [])
  {

    $response = $this->client->request(self::POST, $path, [
      'json' => $data,
      'headers' => $headers
    ]);

    // Converte a resposta em objeto
    $contents = json_decode($response->getBody()->getContents());

    return $contents;
  }

  /**
   * Altera Produto Magento
   * @param $path
   * @param array $data
   * @return void
   */
  public function put($path, $id, $data, array $headers = [])
  {

    $response = $this->client->request(self::PUT, "$path/$id", [
      'json' => $data,
      'headers' => $headers
    ]);

    // Converte a resposta em objeto
    $contents = json_decode($response->getBody()->getContents());

    return $contents;
  }

  /**
   * Obtem o produto
   *
   * @param String $path
   * @param String $id ( skuid )
   * @param mixed $data
   * @param array $headers
   * @return void
   */
  public function get($path, $id, array $data = [], array $headers = [])
  {

    $response = $this->client->request(self::GET, "$path/$id", [
      'headers' => $headers
    ]);

    // Converte a resposta em objeto
    $contents = json_decode($response->getBody()->getContents());

    return $contents;
  }

  /**
   * Obtem todos itens   *
   * @param String $path
   * @param String $id ( skuid )
   * @param mixed $data
   * @param array $headers
   * @return void
   */
  public function getAll($path, SearchCriteria $searchCriteria, array $headers = [])
  {
    // Faz o filtro
    $queryParams = "$path?"
      . $searchCriteria->getField()
      . '&' . $searchCriteria->getValue()
      . '&' . $searchCriteria->getConditionType();

    $response = $this->client->request(
      self::GET,
      $queryParams,
      [
        'headers' => $headers
      ]
    );

    // Converte a resposta em objeto
    $contents = json_decode($response->getBody()->getContents());

    $newCollection = collect();

    foreach (($contents->items ?? []) as $object) {
      $newCollection->put($object->sku, $object);
    }
    return $newCollection;
  }
}
