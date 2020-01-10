<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\Magento\Auth\AuthService;
use App\Models\MarkVn\Configuration;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TestCommand';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(AuthService $authorization)
    {
        $token = $authorization->post('integration/admin/token', [
            'username' => config('app.magento_api_username'),
            'password' => config('app.magento_api_password')
        ]);

        dd($token);
    }
}
