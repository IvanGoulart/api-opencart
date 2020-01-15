<?php

namespace App\Models\Opencart\Customer;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
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

  protected $fillable = [
    'address_id',
    'customer_id',
    'firstname',
    'lastname',
    'company',
    'address_1',
    'address_2',
    'city',
    'postcode',
    'country_id',
    'zone_id',
    'custom_field',  
];




  public function customer()
  {
    return $this->hasMany('App\Models\Opencart\Customer\Customer', 'documentnr', 'documentnr');
  }
}
