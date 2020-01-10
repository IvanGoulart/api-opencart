<?php

namespace App\Models\MarkVn;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
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
    protected $table = 'stock';

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
        'warehouse_id',
        'skuid',
        'stocktype',
        'integracao_flag',
        'integracao_data',
        'seqproduto',
        'datainc',
        'qtdembalagem',
        'company_id',
        'sequsuario',
        'databloq',
        'desccompleta',
        'peso',
        'dataalt',
        'categoria_1',
        'categoria_2',
        'categoria_3',
        'categoria_4',
        'fornecedor',
        'estoque',
        'barcode',
        'embalagem',
        'ncm',
        'data_nao_encontrado'
    ];
}
