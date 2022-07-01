<?php

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__ . "/autentificadora.php";
require_once "Usuario.php";
require_once "Perfil.php";

class MW
{
    
    public function ChequearJWT(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $obj_respuesta = new stdClass();
        $obj_respuesta->mensaje = "Token Invalido!";
        $obj_respuesta->status = 403;

        if (isset($request->getHeader("token")[0])) {
            $token = $request->getHeader("token")[0];

            if ($obj = Autentificadora::verificarJWT($token)) {
                if ($obj->verificado) {
                    $response = $handler->handle($request);
                    $contenidoAPI = (string) $response->getBody();
                    $api_respuesta = json_decode($contenidoAPI);
                    $obj_respuesta->status = $api_respuesta->status;
                } else {
                    $obj_respuesta->mensaje = $obj->mensaje;
                    $contenidoAPI = json_encode($obj_respuesta);
                }
            }
        }

        $response = new ResponseMW();
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

}
