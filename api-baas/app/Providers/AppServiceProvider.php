<?php

namespace App\Providers;

use App\Libs\IMessageBroker;
use App\Libs\MessageBroker\RabbitMQ\RabbitMqProvider;
use App\Repositories\Contracts\IKeyRepository;
use App\Repositories\Contracts\ITransactionRepository;
use App\Repositories\Contracts\IWalletRepository;
use App\Repositories\KeyRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Services\Contracts\ITransactionService;
use App\Services\TransactionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->services();
        $this->repositories();
    }

    private function repositories()
    {
        $this->app->bind(ITransactionRepository::class, TransactionRepository::class);
        $this->app->bind(IWalletRepository::class, WalletRepository::class);
        $this->app->bind(IKeyRepository::class, KeyRepository::class);
    }

    private function services()
    {
        $this->app->bind(ITransactionService::class, TransactionService::class);
        $this->app->bind(IMessageBroker::class, RabbitMqProvider::class);
    }
}
