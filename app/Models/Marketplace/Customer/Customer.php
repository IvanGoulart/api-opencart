<?php

namespace App\Models\Marketplace\Customer;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
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
  protected $table = 'customer';

  /**
   * Remove o autoincremento da chave primária
   * @var boolean
   */
  public $incrementing = false;

  /**
   * Ignora os campos CREATED_AT E UPDATED_AT
   * @var boolean
   */
  public $timestamps = false;

  public function address()
  {
    return $this->hasOne('App\Models\Marketplace\Customer\CustomerAddress', 'documentnr', 'documentnr');
  }

  public function phone()
  {
    return $this->hasOne('App\Models\Marketplace\Customer\CustomerPhone', 'documentnr', 'documentnr');
  }
}
