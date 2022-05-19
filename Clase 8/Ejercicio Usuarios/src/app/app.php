<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../clases/Usuario.php";
require_once __DIR__ . "/../clases/Verificadora.php";


$app = AppFactory::create();

$app->add(\Verificadora::class . ":VerificarUsuario");

$app->group('/usuarios', function (RouteCollectorProxy $grupo) {

  $grupo->get('/', Usuario::class . ':TraerTodos')->add(\Verificadora::class . ":CalcularTiempo");

  $grupo->post('/login', \Usuario::class . ':TraerUno');

  $grupo->post('/', \Usuario::class . ':AgregarUno');

  $grupo->put('/{cadenaJson}', \Usuario::class . ':ModificarUno')->add(\Verificadora::class . ":CalcularTiempo");

  $grupo->delete('/{id}', \Usuario::class . ':BorrarUno');

})->add(\Verificadora::class . ":VerificarAdministrador");

//CORRE LA APLICACIÓN.
try {
  $app->run();
} catch (Exception $e) {
  // We display a error message
  die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}
