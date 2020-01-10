<?php

namespace App\Models\Erp;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;
use App\Models\MarkVn\Configuration;
use Illuminate\Support\Facades\DB;

class LojamarkvnProdutos extends Eloquent
{
    /**
     *Chave primária
     *@var string
     */
    protected $primaryKey = 'seqproduto';
    /**
     * Define a conexão padrão de acesso  a tabela
     * @var string
     */
    protected $connection = 'consinco';

    /**
     * Nome da tabela
     * @var string
     */
    protected $table = 'LOJAMARKVN_PRODUTOS';

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
     * Retorna todos produtos do ERP
     * @param int$warehouse_id
     * @return \Illuminate\Support\Collection
     */
    public static function getAllProductsFromERP(Configuration $seller): \Illuminate\Support\Collection
    {
        $collection = DB::connection('consinco')
            ->table('LOJAMARKVN_PRODUTOS as c')
            ->select('c.*')
            ->where('nrosegmento', $seller->nrosegmento)
            ->where('nroempresa', $seller->company_id)
            //->where('seqfornecedor', 574)
            //->whereNotIn('seqproduto', [96922])
            ->selectRaw(
                'round(precovalidnormal + (precovalidnormal * ?) / 100, 2) as precovalidnormalperc,
                 round(precovalidpromoc + (precovalidpromoc * ?) / 100, 2) as precovalidpromocperc',
                [$seller->percentual, $seller->percentual]
            )
            ->get();

        $newCollection = $collection->map(function ($object) {
            if (!empty($object->ean)) {
                // Gera Skuid
                $object->skuid = self::createSkuiId($object->ean, (int) $object->qtdembalagem);
                // Verifica se produto esta disponivel
                $object->disponivel = self::hasStock($object->ddv, 3);
                // Calcula o estoque ( )
                $object->estoque = !empty($object->disponivel) ?
                    self::getStockByPacking((int) $object->estoque, (int) $object->qtdembalagem) : 0;
                return $object;
            }
        });

        return $newCollection->filter();
    }

    /**
     * Criar o SKUID ean + c + embalagem
     * @param String $codacesso
     * @param Int $qtdembalagem
     * @return String
     */
    public static function createSkuiId(String $codacesso, int $qtdembalagem = 1): String
    {
        return (($qtdembalagem > 1) ? ($codacesso . 'C' . $qtdembalagem) : $codacesso);
    }

    /**
     * Verifica se o produto tem ddv sucifiente
     * @param integer|null $ddv
     * @param integer|null $ddvBase ( caso seja preciso tratar ddv por produto )
     * @return integer
     */
    public static function hasStock(?int $ddv, int $ddvBase = 3): int
    {
        return ($ddv >= $ddvBase) ? 1 : 0;
    }

    /**
     * Divide a embalagem pelo estoque
     * @param Int|null $estoque
     * @param integer $qtdembalagem
     * @return integer
     */
    public static function getStockByPacking(?int $estoque = 0, int $qtdembalagem = 1): int
    {
        return (int) round($estoque / $qtdembalagem);
    }
}
