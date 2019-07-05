<?php

use HelloWorld\Response;

spl_autoload_register(function($class) {
  $parts = explode('\\', $class);
  require  realpath(__DIR__ . '/../src/' . join(DIRECTORY_SEPARATOR, $parts) . '.php');
});

$response = new Response();
echo $response->render();