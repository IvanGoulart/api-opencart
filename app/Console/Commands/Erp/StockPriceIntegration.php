<?php

namespace App\Console\Commands\Erp;

use Illuminate\Console\Command;

use App\Models\Erp\LojamarkvnProdutos;
use App\Libraries\Debug\Log;
use App\Models\MarkVn\Configuration;
use App\Models\MarkVn\StockPriceView;
use Illuminate\Support\Facades\DB;
use App\Libraries\Debug\AppExecutionTime;
use App\Models\MarkVn\Stock;
use App\Models\MarkVn\Price;

class StockPriceIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'StockPriceIntegration {--id=}';

    /**\
     * Exibe a mensagem de debug no console
     * @var boolean
     */
    protected $debug = false;

    /**
     *Log
     * @var  App\Libraries\Debug\Log
     */
    protected $log;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        // Arquivo que será escrito o Log
        $filename = "Commands/StockPriceIntegration/" . date('Y-m-d') . '.log';
        // Objeto log
        $this->log = new Log(__CLASS__, __FILE__, $filename, $this->debug);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(AppExecutionTime $appExecutionTime)
    {
        // Log
        $this->log->info($appExecutionTime->start());

        // Obtem o ID da Loja
        $warehouse_id = (int) $this->option('id');

        // Obtem a conexão
        $conn = DB::connection('lojamarkvn')->getPdo();

        // Obtem os parametros da Loja
        $seller = Configuration::findOrfail($warehouse_id);

        // Todos Produtos gravados na tabela STOCK
        $collectionMarkVn = StockPriceView::getAllProductsGroupBySkuId($seller);

        // Lê a VIEW DE PRODUTOS NA C5
        $collectionC5 = LojamarkvnProdutos::getAllProductsFromERP($seller);

        // Para cada item na C5
        $collectionC5->each(function ($product) use (
            $collectionMarkVn,
            $seller,
            $conn
        ) {

            try {

                // Inicia a transação
                $conn->beginTransaction();
                // Data alteração/inclusão
                $data = date('Y/m/d H:i:s');

                if (
                    // Produto novo
                    empty($collectionMarkVn[$product->skuid])
                    // Que tenha estoque ou embalagem ativa pra compra
                    and (!empty(($product) or $product->statuscompra = 'S'))
                ) {
                    // Grava Estoque
                    $stock = new Stock;
                    $stockFields = [
                        'warehouse_id' => $seller->warehouse_id,
                        'skuid' => $product->skuid,
                        'stocktype' => $product->disponivel,
                        'seqproduto' => $product->seqproduto,
                        'qtdembalagem' => $product->qtdembalagem,
                        'company_id' => $product->nroempresa,
                        'desccompleta' => $product->descricao,
                        'peso' => $product->pesobruto,
                        'estoque' => $product->estoque,
                        'fornecedor' => $seller->fornecedor,
                        'embalagem' => $product->embalagem,
                        'integracao_flag' => 0,
                    ];

                    $stock->fill($stockFields);
                    $stock->save();

                    // Grava Preço
                    $price = new Price;
                    $priceFields = [
                        'warehouse_id' => $seller->warehouse_id,
                        'skuid' => $product->skuid,
                        'seqproduto' => $product->seqproduto,
                        'company_id' => $product->nroempresa,
                        'pricevalue' => $product->precovalidnormalperc,
                        'pricepromo' => $product->precovalidpromocperc,
                        'iniciopromo' => $product->dtainicio,
                        'fimpromo' => $product->dtafim,
                        'pricetp' => 'DFL',
                        'integracao_flag' => 0, // Produto novo
                    ];

                    $price->fill($priceFields);
                    $price->save();
                    // Log
                    $this->log->info("Gravou Produto: {$product->skuid} - Stock:" . json_encode($stockFields) . "- Price:" . json_encode($priceFields));
                }

                // Produto alterado
                if (!empty($collectionMarkVn[$product->skuid])) {

                    // Obtem o ultimo estoque/preço enviado do produto
                    $oldProduct = $collectionMarkVn[$product->skuid];

                    // Verifica se foi alteração de ESTOQUE
                    if (
                        $oldProduct->estoque <> $product->estoque
                        or $oldProduct->stocktype <> $product->disponivel
                    ) {
                        // Campos
                        $stockFields = [
                            'estoque' => $product->estoque,
                            'stocktype' => $product->disponivel,
                            'dataalt' => $data,
                            'integracao_flag' => 2, // Produto Alterado
                        ];
                        // Altera pra inativo
                        Stock::where('warehouse_id', $seller->warehouse_id)
                            ->where('skuid', $product->skuid)
                            ->update($stockFields);
                        // Log
                        $this->log->info("Alterou Produto: {$product->skuid} - Stock:" . json_encode($stockFields));
                    }

                    // Verifica se foi alteração de PREÇO
                    if ($oldProduct->pricevalue <> $product->precovalidnormalperc) {

                        $priceFields = [
                            'pricevalue' => $product->precovalidnormalperc,
                            'dataalt' => $data,
                            'integracao_flag' => 2, // Produto Alterado
                        ];
                        // Altera pra inativo
                        Price::where('warehouse_id', $seller->warehouse_id)
                            ->where('skuid', $product->skuid)
                            ->update($priceFields);
                        // Log
                        $this->log->info("Alterou Produto: {$product->skuid} - Price:" . json_encode($priceFields));
                    }
                }
                $conn->commit();

                $collectionMarkVn->pull($product->skuid);
            } catch (\Exception $ex) {
                $conn->rollBack();
                $this->log->error("Erro ao atualizar produto: $product->skuid. Mensagem: " . $ex->getMessage());
            }
        });

        // Se por algum motivo a view da C5 não trouxer o produto, ele é bloqueado
        $collectionMarkVn->each(function ($product, $skuid) use ($conn) {
            try {
                // Só zera se aind anão tiver zerado
                if (!empty($product->estoque) or !empty($product->pricevalue)) {
                    // Inicia a transação
                    $conn->beginTransaction();
                    // Zera estoque e preço
                    StockPriceView::blockProduct($product->warehouse_id, $skuid);
                    $conn->commit();
                    // Log
                    $this->log->info("Bloqueou produto:" . json_encode($product));
                }
            } catch (\Exception $ex) {
                $conn->rollBack();
                $this->log->error("Erro ao bloquear produto: $product->skuid. Mensagem: " . $ex->getMessage());
            }
        });
        // Log
        $this->log->info($appExecutionTime->end());
    }
}
