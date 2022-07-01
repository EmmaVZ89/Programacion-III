<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../poo/Usuario.php";
require_once __DIR__ . "/../poo/Perfil.php";
require_once __DIR__ . "/../poo/MW.php";


$app = AppFactory::create();

$app->post('/usuario', \Usuario::class . ':AgregarUno')
  ->add(\MW::class . ':ChequearJWT');
$app->get('/', \Usuario::class . ':TraerTodos');

$app->post("/", \Perfil::class . ':AgregarUno')
  ->add(\MW::class . ':ChequearJWT');
$app->get('/perfil', \Perfil::class . ':TraerTodos');

$app->post("/login", \Usuario::class . ':VerificarUsuario');
$app->get("/login", \Usuario::class . ':ChequearJWT');

$app->group('/perfiles', function (RouteCollectorProxy $grupo) {
  $grupo->delete("/{id_perfil}", \Perfil::class . ':BorrarUno');
  $grupo->put("/{id_perfil}/{perfil}", \Perfil::class . ':ModificarUno');
})->add(\MW::class . ':ChequearJWT');

$app->group('/usuarios', function (RouteCollectorProxy $grupo) {
  $grupo->delete("/{id_usuario}", \Usuario::class . ':BorrarUno');
  $grupo->post("/", \Usuario::class . ':ModificarUno');
})->add(\MW::class . ':ChequearJWT');

$app->get('/pdf', \Usuario::class . ':ListarPdf')
  ->add(\MW::class . ':ChequearJWT');

try {
  //CORRE LA APLICACIÓN.
  $app->run();
} catch (Exception $e) {
  // Muestro mensaje de error
  die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}
