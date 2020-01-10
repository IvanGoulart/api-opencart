<?php

namespace App\Models\Opencart;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
          /**
   * Identificador do produto
   * @var string
   */
  protected $primaryKey = 'address_id';
  /**
   * Define a conexão padrão de acesso  a tabela
   * @var string
   */
  protected $connection = 'mysql';

  /**
   * Nome da tabela
   * @var string
   */
  protected $table = 'address';

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

  public function customer (){
    return $this->hasMany('App\Models\Opencart\Customer','customer_id','address_id');
}
}
