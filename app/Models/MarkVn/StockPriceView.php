<?php

namespace App\Models\MarkVn;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;
use App\Models\MarkVn\Configuration;
use App\Models\MarkVn\Stock;
use App\Models\MarkVn\Price;

class StockPriceView extends Eloquent
{
    /**
     * Identificador do produto
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
    protected $table = 'stock_price_view';

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
     * Retorna uma colecção de skus agrupados por skuid
     * @param int$warehouse_id
     * @return \Illuminate\Support\Collection
     */
    public static function getAllProductsGroupBySkuId(Configuration $seller): \Illuminate\Support\Collection
    {
        $collection = self::where('warehouse_id', $seller->warehouse_id)->get();

        $newCollection = collect();

        $collection->each(function ($object) use ($newCollection) {
            $newCollection->put($object->skuid, (object) $object->toArray());
        });

        return $newCollection;
    }

    /**
     * Zera estoque e preço
     *
     * @param int $warehouse_id
     * @param String $skuid
     * @return void
     */
    public static function blockProduct($warehouse_id, $skuid): void
    {
        $integracao_data = date('Y/m/d H:i:s');
        $integracao_flag = 0;

        // Zero o estoque
        Stock::where('warehouse_id', $warehouse_id)
            ->where('skuid', $skuid)
            ->update(
                [
                    'estoque' => 0,
                    'dataalt' => $integracao_data,
                    'integracao_flag' => $integracao_flag,
                ]
            );

        // Zero o preço
        Price::where('warehouse_id', $warehouse_id)
            ->where('skuid', $skuid)
            ->update(
                [
                    'pricevalue' => 0,
                    'pricepromo' => 0,
                    'iniciopromo' => null,
                    'fimpromo' => null,
                    'dataalt' => $integracao_data,
                    'integracao_flag' => $integracao_flag,
                ]
            );
    }

    /**
     * Zera estoque e preço
     *
     * @param int $warehouse_id
     * @param String $skuid
     * @return void
     */
    public static function markAsIntegrated($warehouse_id, $skuid): void
    {
        $integracao_data = date('Y/m/d H:i:s');
        $integracao_flag = 1;

        // Zero o estoque
        Stock::where('warehouse_id', $warehouse_id)
            ->where('skuid', $skuid)
            ->update(
                [
                    'dataalt' => $integracao_data,
                    'integracao_data' => $integracao_data,
                    'integracao_flag' => $integracao_flag
                ]
            );

        // Zero o preço
        Price::where('warehouse_id', $warehouse_id)
            ->where('skuid', $skuid)
            ->update(
                [
                    'dataalt' => $integracao_data,
                    'integracao_data' => $integracao_data,
                    'integracao_flag' => $integracao_flag,
                ]
            );
    }
}
