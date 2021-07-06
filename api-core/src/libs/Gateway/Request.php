<?php

namespace Libs\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Request
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://run.mocky.io'
        ]);

        return $this;
    }

    public function get($uri, array $options = [])
    {
        try {
            return $this->client->get($uri, $options);
        } catch (ClientException $e) {
            return new Response($e->getCode(), $e->getRequest()->getBody());
        } catch (ServerException $e) {
            return new Response($e->getCode(), $e->getRequest()->getBody());
        }
    }
}
