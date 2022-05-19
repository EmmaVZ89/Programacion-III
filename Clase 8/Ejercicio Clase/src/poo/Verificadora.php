<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once "accesoDatos.php";

class Verificadora
{

    public function VerificarUsuario(Request $request, RequestHandler $handler): ResponseMW
    {
        $arrayDeParametros = $request->getParsedBody();
        $obj_json = json_decode($arrayDeParametros["obj_json"]);
        $contenidoAPI = "";

        if (Verificadora::ExisteUsuario($obj_json)) {
            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();
        } else {
            $obj = new stdClass();
            $obj->mensaje = "ERROR, correo o clave incorrecta";
            $obj->status = 403;
            $contenidoAPI = json_encode($obj);
        }

        $response = new ResponseMW();
        $response->getBody()->write($contenidoAPI);
        return $response;
    }

    public static function ExisteUsuario($obj)
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT u.id, u.nombre, u.apellido, u.correo, 
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

    public function VerificarCorreoYClave(Request $request, RequestHandler $handler): ResponseMW
    {
        $obj = new stdClass();
        $contenidoAPI = "";

        $arrayDeParametros = $request->getParsedBody();
        $obj_json = json_decode($arrayDeParametros["obj_json"]);

        if (isset($obj_json->correo) && isset($obj_json->clave)) {
            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();
        } else {
            if(isset($obj_json->correo)) {
                $obj->mensaje = "Falta atributo Clave";
            } else if(isset($obj_json->clave)) {
                $obj->mensaje = "Falta atributo Correo";
            } else {
                $obj->mensaje = "Faltan atributos Correo y Clave";
            }
            $obj->status = 403;
            $contenidoAPI = json_encode($obj);
        }

        $response = new ResponseMW();
        $response->getBody()->write($contenidoAPI);
        return $response;
    }

    public function VerificarObjJson(Request $request, RequestHandler $handler): ResponseMW
    {
        $metodo = $request->getMethod();
        $contenidoAPI = "";

        if ($metodo === "GET") {
            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();
        } else if ($metodo === "POST") {
            $arrayDeParametros = $request->getParsedBody();
            if (isset($arrayDeParametros["obj_json"])) {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
            } else {
                $obj = new stdClass();
                $obj->mensaje = "Falta parametro obj_json!!";
                $contenidoAPI = json_encode($obj);
            }
        }

        $response = new ResponseMW();
        $response->getBody()->write($contenidoAPI);
        return $response;
    }
}
