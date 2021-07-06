<?php

namespace App\Services;

use App\Enums\TransactionStatusEnum;
use App\Libs\IMessageBroker;
use App\Models\User;
use App\Repositories\Contracts\IKeyRepository;
use App\Repositories\Contracts\ITransactionRepository;
use App\Repositories\Contracts\IWalletRepository;
use App\Services\Contracts\ITransactionService;
use Exception;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TransactionService implements ITransactionService
{
    /**
     * @var ITransactionRepository
     */
    private $repository;

    /**
     * @var IWalletRepository
     */
    private $walletRepository;

    /**
     * @var IKeyRepository
     */
    private $keyRepository;

    /**
     * @var IMessageBroker
     */
    private $messageBroker;

    public function __construct(
        ITransactionRepository $repository,
        IWalletRepository $walletRepository,
        IKeyRepository $keyRepository,
        IMessageBroker $messageBroker
    ) {
        $this->repository = $repository;
        $this->walletRepository = $walletRepository;
        $this->keyRepository = $keyRepository;
        $this->messageBroker = $messageBroker;
    }

    public function create(User $user, array $data)
    {
        $walletTo = $this->walletRepository->find($user->wallet->id, ['id', 'balance']);
        $balance = $walletTo->balance - $data['total'];
        if ($balance <= 0) throw new RuntimeException('Insufficient balance', 422);

        try {
            DB::beginTransaction();

            $key = $this->keyRepository->findOne(
                ['key' => $data['key_code'], 'type' => $data['key_type']],
                ['id', 'wallet_id']
            );

            $data = [
                'wallet_from' => $user->wallet->id,
                'wallet_to' => $key->wallet_id,
                'status' => TransactionStatusEnum::PROCESSING,
                'total' => $data['total']
            ];

            $transaction = $this->repository->create($data);

            $this->walletRepository->update(
                $user->wallet->id, 
                ['balance' => $balance]
            );

            $this->messageBroker->publish(
                array_merge(['transaction' => $transaction->id], $data), 
                'transactions_request'
            );

            DB::commit();

            return $transaction;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
