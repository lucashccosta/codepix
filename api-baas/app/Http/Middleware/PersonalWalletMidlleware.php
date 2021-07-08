<?php

namespace App\Http\Middleware;

use App\Enums\WalletTypeEnum;
use Closure;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class PersonalWalletMiddleware
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
        $wallet = Auth::user()->wallet;
        if (empty($wallet) || $wallet->type !== WalletTypeEnum::PERSONAL) {
            throw new RuntimeException('Bad request', 400);
        }

        return $next($request);
    }
}
