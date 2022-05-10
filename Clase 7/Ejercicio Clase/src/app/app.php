<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../clases/Usuario.php";


$app = AppFactory::create();

// Login
$app->get('/', Usuario::class . ':ArmarLogin');
$app->get('/Principal', Usuario::class . ':ArmarPrincipal');
$app->get('/Salir', Usuario::class . ':SalirSesion');


$app->group('/usuario', function (RouteCollectorProxy $grupo) {

  $grupo->get('/', Usuario::class . ':TraerTodos'); // OK
  $grupo->post('/login', \Usuario::class . ':TraerUno'); // OK
  $grupo->post('/', \Usuario::class . ':AgregarUno'); // OK
  $grupo->put('/{cadenaJson}', \Usuario::class . ':ModificarUno'); // OK
  $grupo->delete('/{id}', \Usuario::class . ':BorrarUno'); // OK
});

//CORRE LA APLICACIÓN.
try {
  $app->run();
} catch (Exception $e) {
  // We display a error message
  die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}
