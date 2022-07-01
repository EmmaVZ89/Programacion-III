<?php

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__ . "/autentificadora.php";
require_once "Usuario.php";
require_once "Barbijo.php";

class MW
{
    // Middleware Usuario
    public function ValidarCorreoYClave(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->status = 403;
        $obj = null;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode(($arrayDeParametros["user"]));
        } else if (isset($arrayDeParametros["usuario"])) {
            $obj = json_decode(($arrayDeParametros["usuario"]));
        }

        if ($obj) {
            if (isset($obj->correo) && isset($obj->clave)) {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $obj_respuesta->status = $api_respuesta->status;
            } else {
                $mensaje_error = "Parametros faltantes: \n";
                if (!isset($obj->correo)) {
                    $mensaje_error .= "- correo \n";
                }
                if (!isset($obj->clave)) {
                    $mensaje_error .= "- clave \n";
                }
                $obj_respuesta->mensaje = $mensaje_error;
                $contenidoAPI = json_encode($obj_respuesta);
            }
        } else {
            $obj_respuesta->mensaje = "No se envio el obj json 'user' o 'usuario";
            $contenidoAPI = json_encode($obj_respuesta);
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function ValidarParametrosVacios(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->status = 409;
        $obj = null;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode(($arrayDeParametros["user"]));
        } else if (isset($arrayDeParametros["usuario"])) {
            $obj = json_decode(($arrayDeParametros["usuario"]));
        }

        if ($obj->correo != "" && $obj->clave != "") {
            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();
            $api_respuesta = json_decode($contenidoAPI);
            $obj_respuesta->status = $api_respuesta->status;
        } else {
            $mensaje_error = "Parametros vacios: \n";
            if ($obj->correo == "") {
                $mensaje_error .= "- correo \n";
            }
            if ($obj->clave == "") {
                $mensaje_error .= "- clave \n";
            }
            $obj_respuesta->mensaje = $mensaje_error;
            $contenidoAPI = json_encode($obj_respuesta);
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function VerificarSiExisteUsuario(Request $request, RequestHandler $handler): ResponseMW
    {
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->mensaje = "El usuario no existe!";
        $obj_respuesta->status = 403;
        $obj = null;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode(($arrayDeParametros["user"]));
        } else if (isset($arrayDeParametros["usuario"])) {
            $obj = json_decode(($arrayDeParametros["usuario"]));
        }

        if ($obj) {
            if (Usuario::TraerUsuario($obj)) {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $obj_respuesta->status = $api_respuesta->status;
            } else {
                $contenidoAPI = json_encode($obj_respuesta);
            }
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function VerificarCorreo(Request $request, RequestHandler $handler): ResponseMW
    {
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->mensaje = "El correo existe!";
        $obj_respuesta->status = 403;
        $obj = null;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode(($arrayDeParametros["user"]));
        } else if (isset($arrayDeParametros["usuario"])) {
            $obj = json_decode(($arrayDeParametros["usuario"]));
        }

        if ($obj) {
            if (!Usuario::TraerUsuarioPorCorreo($obj->correo)) {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $api_respuesta = json_decode($contenidoAPI);
                $obj_respuesta->status = $api_respuesta->status;
            } else {
                $contenidoAPI = json_encode($obj_respuesta);
            }
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

}
