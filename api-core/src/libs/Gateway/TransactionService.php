<?php

namespace Libs\Gateway;

use Exception;

class TransactionService
{
    /**
     * @var TransactionService
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     * @return TransactionService The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }

    public function create(
        string $payer,
        string $payee,
        float $total
    ) : Response 
    {
        //mock external transaction create call
        $response = (new Request)->get('/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if ($response instanceof Response) return $response;

        $statusCode = $response->getStatusCode();
        $content = json_decode($response->getBody());
        if ($content->message !== 'Autorizado') $statusCode = 422;

        return new Response($statusCode, $response->getBody());
    }
}