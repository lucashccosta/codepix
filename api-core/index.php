<?php

use Dotenv\Dotenv;

require_once __DIR__.'/vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__);
$env->load();

require __DIR__.'/src/bootstrap/index.php';