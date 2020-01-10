<?php

namespace App\Models\Opencart;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
      /**
   * Identificador do produto
   * @var string
   */
  protected $primaryKey = 'customer_id';
  /**
   * Define a conexão padrão de acesso  a tabela
   * @var string
   */
  protected $connection = 'mysql';

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


  public function address(){
    return $this->hasOne('App\Models\Opencart\Address', 'address_id', 'customer_id');
}

}
