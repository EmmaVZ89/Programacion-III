<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../poo/Usuario.php";
require_once __DIR__ . "/../poo/Barbijo.php";
require_once __DIR__ . "/../poo/MW.php";


$app = AppFactory::create();

$app->post('/usuarios', \Usuario::class . ':AgregarUno')
->add(\MW::class . '::VerificarCorreo')
->add(\MW::class . '::ValidarParametrosVacios')
->add(\MW::class . ':ValidarCorreoYClave');

$app->get('/', \Usuario::class . ':TraerTodos');

$app->post("/", \Barbijo::class . ':AgregarUno');
$app->get('/barbijos', \Barbijo::class . ':TraerTodos');

$app->post("/login", \Usuario::class . ':VerificarUsuario')
  ->add(\MW::class . ':VerificarSiExisteUsuario')
  ->add(\MW::class . '::ValidarParametrosVacios')
  ->add(\MW::class . ':ValidarCorreoYClave');
$app->get("/login", \Usuario::class . ':ChequearJWT');

$app->delete("/", \Barbijo::class . ':BorrarUno');
$app->put("/", \Barbijo::class . ':ModificarUno');

// PDF
$app->get("/pdf", \Usuario::class . ':ListarPdf');

try {
  //CORRE LA APLICACIÓN.
  $app->run();
} catch (Exception $e) {
  // Muestro mensaje de error
  die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}
