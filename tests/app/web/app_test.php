<?php

use Symfony\Component\HttpFoundation\Request;

umask(0000);

require __DIR__ . '/../autoload.php';
$kernel = new AppKernel('test', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
