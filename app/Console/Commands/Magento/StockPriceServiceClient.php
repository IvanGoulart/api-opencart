<?php

namespace App\Console\Commands\Magento;

use Illuminate\Console\Command;

use App\Libraries\Debug\Log;
use App\Models\MarkVn\Configuration;
use App\Models\MarkVn\StockPriceView;
use Illuminate\Support\Facades\DB;
use App\Libraries\Debug\AppExecutionTime;

use App\Libraries\Magento\Products\Product;
use App\Libraries\Magento\Products\StockItem;
use App\Libraries\Magento\Products\ExtensionAttribute;

use App\Http\Services\Magento\Auth\AuthService;
use App\Http\Services\Magento\Products\ProductService;
use App\Libraries\Magento\Utils\SearchCriteria;

class StockPriceServiceClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'StockPriceServiceClient {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Integra o estoque e preço no MAGENTO';

    /**\
     * Exibe a mensagem de debug no console
     * @var boolean
     */
    protected $debug = true;

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
        $filename = "Commands/StockPriceIntegrationClient/" . date('Y-m-d') . '.log';
        // Objeto log
        $this->log = new Log(__CLASS__, __FILE__, $filename, $this->debug);
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(
        AppExecutionTime $appExecutionTime,
        AuthService $authorization,
        ProductService $productService
    ) {
        try {

            // Log
            $this->log->info($appExecutionTime->start());

            // Obtem o ID da Loja
            $warehouse_id = (int) $this->option('id');

            // Obtem a conexão
            $conn = DB::connection('lojamarkvn')->getPdo();

            // Obtem os parametros da Loja
            $seller = Configuration::findOrfail($warehouse_id);

            // Todos Produtos gravados na tabela Stock/Price
            $collectionMarkVn = StockPriceView::where('warehouse_id', $seller->warehouse_id)
                ->where('skuid', '7891132019403C48')
                ->where(function ($query) {
                    $query->where('stock_integracao_flag', '<>', 1)
                        ->orWhere('integracao_flag',  '<>', 1);
                })
                ->get();

            // Tenta autenticar no sistema
            $token = $authorization->post('integration/admin/token', [
                'username' => config('app.magento_api_username'),
                'password' => config('app.magento_api_password')
            ]);

            // Log
            $this->log->info("Token:$token");

            // Obtem todos produtos do Magento que estão visiveis
            $allMagentoProducts = $productService->getAll(
                "products",
                new SearchCriteria('visibility', 1, 'neq'),
                ['Authorization' => "Bearer $token"]
            );

            // Para cada item na Stock/Price
            $integratedProducts = $collectionMarkVn->map(function ($productMarkVn)
            use (
                $productService,
                $token,
                $allMagentoProducts
            ) {

                try {

                    // Dados padrão
                    $type_id = 'simple';
                    $status = 1;
                    $visibility = 1; // não visivel por padrão
                    $attribute_set_id = 4;

                    // Se não for um produto novo ( será = 2 )
                    if (!empty($allMagentoProducts[$productMarkVn->skuid])) {
                        // Obtem os dados do produto visivel
                        $magentoProduct = $allMagentoProducts[$productMarkVn->skuid];
                        // Mantem os dados de visibilidade do MAGENTO
                        $type_id = $magentoProduct->type_id;
                        $status = $magentoProduct->status;
                        $visibility = $magentoProduct->visibility;
                        $attribute_set_id = $magentoProduct->attribute_set_id;

                        // Log
                        $this->log->info('Produto no Magento:' . json_encode($magentoProduct, JSON_PRETTY_PRINT));
                    }

                    // Verifica se tem estoque
                    $is_in_stock = !empty($productMarkVn->estoque) ? true : false;

                    // Cria o produto a ser integrado
                    $product = new Product(
                        $productMarkVn->skuid,
                        $productMarkVn->desccompleta,
                        $productMarkVn->pricevalue,
                        $type_id,
                        $status,
                        $visibility,
                        $attribute_set_id
                    );

                    // Cria o objeto estoque
                    $extensionAttribute = new ExtensionAttribute;
                    $extensionAttribute->addStockItem(
                        new StockItem(
                            $productMarkVn->estoque,
                            $is_in_stock
                        )
                    );

                    // Adiciona o estoque ao produto
                    $product->setExtensionAttributes($extensionAttribute);
                    // Log
                    $this->log->info('Request.POST:' . json_encode($product, JSON_PRETTY_PRINT));

                    // Tenta integrar o produto no Magento
                    $response = $productService->post(
                        'products',
                        $product,
                        [
                            'Authorization' => "Bearer $token"
                        ]
                    );

                    // Log
                    $this->log->info('Response.POST:' . json_encode($response, JSON_PRETTY_PRINT));

                    // Retorna o produto integrado
                    return $productMarkVn;
                } catch (\Exception $ex) {
                    $this->log->error("Erro ao atualizar produto: $productMarkVn->skuid. Mensagem: " . $ex->getMessage());
                }
            });

            // Para cada produto integrado no magento atualiza STOCK/PRICE
            $integratedProducts->each(function ($product) use ($conn) {
                try {
                    // Inicia a transação
                    $conn->beginTransaction();
                    // Zera estoque e preço
                    StockPriceView::markAsIntegrated($product->warehouse_id, $product->skuid);
                    // Faz commit
                    $conn->commit();
                    // Log
                    $this->log->info("Atualizou produto:" . json_encode($product));
                } catch (\Exception $ex) {
                    $conn->rollBack();
                    $this->log->error("Erro ao bloquear produto: $product->skuid. Mensagem: " . $ex->getMessage());
                }
            });

            // Log
            $this->log->info($appExecutionTime->end());
        } catch (\Exception $ex) {
            $this->log->error("Erro URGENTE integração parada: " . $ex->getMessage());
        }
    }
}
