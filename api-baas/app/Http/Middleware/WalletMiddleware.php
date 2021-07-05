<?php

namespace App\Http\Middleware;

use App\Models\Wallet;
use Closure;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class WalletMiddleware
{
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
        $wallet = Wallet::select('id', 'type')
            ->where(['id' => $httpWallet, 'user_id' => Auth::user()->id])
            ->first();

        if (empty($wallet)) {
            throw new RuntimeException('Forbidden', 403);
        }

        Auth::user()->wallet = $wallet;

        return $next($request);
    }
}
