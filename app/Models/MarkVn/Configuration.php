<?php

namespace App\Models\MarkVn;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class Configuration extends Eloquent
{
    /**
     *Chave primária
     *@var string
     */
    protected $primaryKey = 'warehouse_id';
    /**
     * Define a conexão padrão de acesso  a tabela
     * @var string
     */
    protected $connection = 'lojamarkvn';

    /**
     * Nome da tabela
     * @var string
     */
    protected $table = 'configuracao';

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
