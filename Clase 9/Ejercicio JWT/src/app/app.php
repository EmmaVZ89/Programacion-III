<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../clases/Usuario.php";
require_once __DIR__ . "/../clases/cd.php";
require_once __DIR__ . "/../clases/Verificadora.php";


$app = AppFactory::create();

$app->post('/login[/]', \Verificadora::class . ':VerificarUsuario')
  ->add(\Verificadora::class . ':ValidarParametrosUsuario');

$app->get('/login/test', \Verificadora::class . ':ObtenerDataJWT')
  ->add(\Verificadora::class . ':ChequearJWT');

$app->group('/json_bd', function (RouteCollectorProxy $grupo) {

  $grupo->get('/', \cd::class . ':TraerTodos');

  $grupo->get('/{id}', \cd::class . ':TraerUno');

  $grupo->post('/', \cd::class . ':AgregarUno')->add(\Verificadora::class . ':ValidarParametrosCDAgregar');

  $grupo->put('/', \cd::class . ':ModificarUno')->add(\Verificadora::class . ':ValidarParametrosCDModificar');

  $grupo->delete('/', \cd::class . ':BorrarUno')->add(\Verificadora::class . ':ValidarParametrosCDBorrar');
  
})->add(\Verificadora::class . ':ChequearJWT');

try {
  //CORRE LA APLICACIÓN.
  $app->run();
} catch (Exception $e) {
  // Muestro mensaje de error
  die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}
