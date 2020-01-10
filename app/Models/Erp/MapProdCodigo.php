<?php

namespace App\Models\Erp;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MapProdCodigo extends Eloquent
{
  /**
   * Identificador do produto
   * @var string
   */
  protected $primaryKey = 'codacesso';
  /**
   * Define a conexão padrão de acesso  a tabela
   * @var string
   */
  protected $connection = 'consinco';

  /**
   * Nome da tabela
   * @var string
   */
  protected $table = 'map_prodcodigo';

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
}
