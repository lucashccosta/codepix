<?php

namespace App\Auth\Providers;

use App\Auth\JwtToken;
use App\Exceptions\InvalidJwtException;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class JwtProvider implements UserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        throw new \BadMethodCallException('Unexpected method [retrieveByCredentials] call');
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        throw new \BadMethodCallException('Unexpected method [retrieveById] call');
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        try {
            if (!$token instanceof JwtToken) throw new Exception();
            return User::findOrFail($token->payload->id);
        } catch (Exception $e) {
            throw new InvalidJwtException('Invalid jwt token');
        }
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        throw new \BadMethodCallException('Unexpected method [updateRememberToken] call');
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        throw new \BadMethodCallException('Unexpected method [validateCredentials] call');
    }
}
