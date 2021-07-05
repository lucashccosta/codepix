<?php

namespace App\Providers;

use App\Models\User;
use App\Auth\Guards\JwtGuard;
use App\Auth\Providers\JwtProvider;
use App\Enums\WalletTypeEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // $this->app['auth']->viaRequest('api', function ($request) {
        //     if ($request->input('api_token')) {
        //         return User::where('api_token', $request->input('api_token'))->first();
        //     }
        // });

        Auth::extend('jwt-session', function ($app, $name, array $config) {
            return new JwtGuard(
                Auth::createUserProvider($config['provider']),
                $app['request']
            );
        });

        // Authentication user (set auth::user())
        Auth::provider('jwt', function ($app, array $config) {
            return new JwtProvider();
        });

        // 
        Gate::define('personal', function ($user) {
            $wallet = $user->wallet;
            return !(empty($wallet) || $wallet->type !== WalletTypeEnum::PERSONAL);
        });
    }
}
