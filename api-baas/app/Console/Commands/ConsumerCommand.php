<?php

namespace App\Console\Commands;

use App\Libs\IMessageBroker;
use App\Listeners\TransactionListener;
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
        $messageBroker->consume(
            $this->argument('queue'),
            function ($data) {
                (new TransactionListener($data['status']))->listen($data);
            }
        );
    }
}
