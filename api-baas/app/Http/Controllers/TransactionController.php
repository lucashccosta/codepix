<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\Contracts\ITransactionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @var ITransactionService
     */
    private $service;

    public function __construct(ITransactionService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $transaction = $this->service->create(
            Auth::user(),
            $request->all()
        );

        return $this->responseCreated(new TransactionResource($transaction));
    }
}
