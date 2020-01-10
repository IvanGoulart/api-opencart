<?php

namespace App\Models\MarkVn;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    /**
     * Chave primária
     * @var string
     */
    protected $primaryKey = 'skuid';
    /**
     * Define a conexão padrão de acesso  a tabela
     * @var string
     */
    protected $connection = 'lojamarkvn';

    /**
     * Nome da tabela
     * @var string
     */
    protected $table = 'price';

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
     * Campos que serão ser preenchidos na Model
     * @var array
     */
    protected $fillable = [
        'skuid',
        'pricevalue',
        'integracao_flag',
        'integracao_data',
        'seqproduto',
        'pricetp',
        'warehouse_id',
        'iniciopromo',
        'fimpromo',
        'datainc',
        'company_id',
        'dataalt'
    ];
}
