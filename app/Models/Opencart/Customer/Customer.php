<?php

namespace App\Models\Opencart\Customer;

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


  /**
   * Obter o endereço do cliente
   * @return App\Models\Opencart\Address
   */
  public function address()
  {
    return $this->hasOne('App\Models\Opencart\Customer\Address', 'customer_id', 'customer_id');
  }


  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['password', 'token'];

  /**
   * Traduz o JSON para um objeto usavel em PHP  
   * @param string $value
   * @return void object 
   */
  public function getCustomFieldAttribute($value)
  {
    return json_decode($value);
  }
}
