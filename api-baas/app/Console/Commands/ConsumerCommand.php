<?php

namespace App\Console\Commands;

use App\Enums\TransactionStatusEnum;
use App\Libs\IMessageBroker;
use App\Repositories\Contracts\IWalletRepository;
use Illuminate\Console\Command;

class ConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message-broker:consume
                            {queue : Queue name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Message broker consumer';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $messageBroker = app()->make(IMessageBroker::class);
        $walletRepository = app()->make(IWalletRepository::class);
        $messageBroker->consume(
            $this->argument('queue'), 
            function ($data) use ($walletRepository) {
                if ($data['status'] === TransactionStatusEnum::SUCCESS) {
                    $walletRepository->increment(
                        $data['wallet_to'],
                        'balance',
                        (float) $data['total']
                    );
                }
                else if ($data['status'] === TransactionStatusEnum::FAILED) {
                    $walletRepository->increment(
                        $data['wallet_from'],
                        'balance',
                        (float) $data['total']
                    );
                }
            }
        );
    }
}
