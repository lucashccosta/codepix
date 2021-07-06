<?php

namespace App\Http\Middleware;

use App\Models\Wallet;
use App\Repositories\Contracts\IWalletRepository;
use Closure;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class WalletMiddleware
{
    private $walletRepository;

    public function __construct()
    {
        $this->walletRepository = app()->make(IWalletRepository::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->headers->has('x-wallet')) {
            throw new RuntimeException('Unauthorized', 401);
        }

        $httpWallet = $request->header('x-wallet');
        $wallet = $this->walletRepository->findOne(
            ['id' => $httpWallet, 'user_id' => Auth::user()->id],
            ['id', 'type', 'balance', 'code']
        );
        
        Auth::user()->wallet = $wallet;
        return $next($request);
    }
}
