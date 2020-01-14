<?php

namespace App\Models\Marketplace\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerPhone extends Model
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
  protected $table = 'customer_phone';

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

  public function customer()
  {
    return $this->hasMany('App\Models\Marketplace\Customer\Customer', 'documentnr', 'documentnr');
  }


}
