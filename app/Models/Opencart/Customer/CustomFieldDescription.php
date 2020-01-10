<?php

namespace App\Models\Opencart\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomFieldDescription extends Model
{
    /**
     * Identificador do produto
     * @var string
     */
    protected $primaryKey = 'custom_field_id';
    /**
     * Define a conexão padrão de acesso  a tabela
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * Nome da tabela
     * @var string
     */
    protected $table = 'custom_field_description';

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
