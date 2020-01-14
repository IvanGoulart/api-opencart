<?php

namespace App\Models\Marketplace\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
      /**
   * Identificador do produto
   * @var string
   */
  protected $primaryKey = 'documentnr';
  /**
   * Define a conexão padrão de acesso  a tabela
   * @var string
   */
  protected $connection = 'lojamarkvn';

  /**
   * Nome da tabela
   * @var string
   */
  protected $table = 'customer_address';

  /**
   * Remove o autoincremento da chave primária
   * @var boolean
   */
  public $incrementing = false;
  public $timestamps = false;

  public function customer()
  {
    return $this->hasOne('App\Models\Marketplace\Customer\Customer', 'documentnr', 'documentnr');
  }

  public function phone()
  {
    return $this->hasOne('App\Models\Marketplace\Customer\CustomerPhone', 'documentnr', 'documentnr');
  }

}
