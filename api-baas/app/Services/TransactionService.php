<?php

namespace App\Services;

use App\Enums\TransactionStatusEnum;
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

    public function __construct(
        ITransactionRepository $repository,
        IWalletRepository $walletRepository,
        IKeyRepository $keyRepository
    ) {
        $this->repository = $repository;
        $this->walletRepository = $walletRepository;
        $this->keyRepository = $keyRepository;
    }

    public function create(User $user, array $data)
    {
        $walletTo = $this->walletRepository->find($user->wallet->id, ['id', 'balance']);
        $balance = $walletTo->balance - $data['total'];
        if ($balance <= 0) throw new RuntimeException('Insufficient balance', 422);

        try {
            DB::beginTransaction();

            //TODO: envia dados para rabbitmq
            
            $key = $this->keyRepository->findOne(
                ['key' => $data['key_code'], 'type' => $data['key_type']],
                ['id', 'wallet_id']
            );

            $transaction = $this->repository->create([
                'wallet_from' => $user->wallet->id,
                'wallet_to' => $key->wallet_id,
                'status' => TransactionStatusEnum::PROCESSING,
                'total' => $data['total']
            ]);

            $this->walletRepository->update(
                $user->wallet->id, 
                ['balance' => $balance]
            );

            DB::commit();

            return $transaction;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
