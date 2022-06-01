<?php

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__ . "/autentificadora.php";
require_once "accesoDatos.php";

class Verificadora
{

    public function VerificarUsuario(Request $request, Response $response, array $args): Response
    {
        $arrayDeParametros = $request->getParsedBody();
        $jwt = null;
        $status = 403;

        if (isset($arrayDeParametros["obj_json"])) {
            $obj = json_decode($arrayDeParametros["obj_json"]);
            if ($usuario = Verificadora::ExisteUsuario($obj)) {
                $data = new stdClass();
                $data->id = $usuario->id;
                $data->nombre = $usuario->nombre;
                $data->correo = $usuario->correo;
                $data->perfil = $usuario->perfil;
                $data->pathFoto = $usuario->pathFoto;

                $jwt =  Autentificadora::crearJWT($data, 300);
                $status = 200;
            }
        }

        $contenidoAPI = json_encode(array("jwt" => $jwt));
        $response = $response->withStatus($status);
        $response->getBody()->write($contenidoAPI);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerDataJWT(Request $request, Response $response, array $args): Response
    {
        $token = $request->getHeader("token")[0];

        $obj_rta = Autentificadora::obtenerPayLoad($token);

        $status = $obj_rta->exito ? 200 : 500;

        $newResponse = $response->withStatus($status);

        $newResponse->getBody()->write(json_encode($obj_rta));

        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    // Sistema de archivos, Base de Datos
    public static function ExisteUsuario($obj)
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT u.id, u.nombre, u.correo, 
            u.clave, u.id_perfil, p.descripcion AS perfil, u.foto AS pathFoto
            FROM usuarios u 
            INNER JOIN perfiles p ON u.id_perfil = p.id
            WHERE u.correo = :correo AND u.clave = :clave"
        );
        $consulta->bindValue(":correo", $obj->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $obj->clave, PDO::PARAM_STR);
        $consulta->execute();

        $usuario = $consulta->fetchObject('Usuario');

        return $usuario;
    }

    // MIDDLEWARES *******************************************************************************
    public function ValidarParametrosUsuario(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $arrayDeParametros = $request->getParsedBody();
        $obj = new stdClass();
        $status = 403;

        if (isset($arrayDeParametros["obj_json"])) {
            $obj_json = json_decode($arrayDeParametros["obj_json"]);
            if (isset($obj_json->correo) && isset($obj_json->clave)) {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
                $status = 200;
            } else {
                if (isset($obj_json->correo)) {
                    $obj->mensaje = "Falta atributo Clave";
                } else if (isset($obj_json->clave)) {
                    $obj->mensaje = "Falta atributo Correo";
                } else {
                    $obj->mensaje = "Faltan atributos Correo y Clave";
                }
                $contenidoAPI = json_encode($obj);
            }
        } else {
            $obj->mensaje = "Falta parametro obj_json!!";
            $contenidoAPI = json_encode($obj);
        }

        $response = new ResponseMW();
        $response = $response->withStatus($status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ChequearJWT(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";
        $obj = new stdClass();
        $status = 500;

        $token = $request->getHeader("token")[0];
        $obj_rta = Autentificadora::obtenerPayLoad($token);

        if ($obj_rta->exito) {
            $response = $handler->handle($request);
            $obj->datos = (string) $response->getBody();
            // $contenidoAPI = (string) $response->getBody();
            $status = 200;
        }
        $obj->exito = $obj_rta->exito;
        $obj->mensaje = $obj_rta->mensaje;
        $obj->datos = $obj_rta->payload;
        
        $contenidoAPI = json_encode($obj);

        $response = new ResponseMW();
        $response = $response->withStatus($status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
