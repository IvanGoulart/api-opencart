<?php

namespace App\Models\Opencart\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
  /**
   * Identificador do produto
   * @var string
   */
  protected $primaryKey = 'cnpj';
  /**
   * Define a conexão padrão de acesso  a tabela
   * @var string
   */
  protected $connection = 'mysql';

  /**
   * Nome da tabela
   * @var string
   */
  protected $table = 'customer_document';

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


  /**
   * Obtem os dados do cliente
   * @return App\Models\Opencart\Customer\Customer
   */
  public function customer()
  {
    return $this->hasOne('App\Models\Opencart\Customer\Customer', 'customer_id', 'customer_id');
  }
}
