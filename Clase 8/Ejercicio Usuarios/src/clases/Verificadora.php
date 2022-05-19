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
        session_start();
        $contenidoAPI = "";
        $arrayDeParametros = $request->getParsedBody();

        if (isset($arrayDeParametros["obj_json"])) {
            session_destroy();
            $obj_json = json_decode($arrayDeParametros["obj_json"]);

            if ($usuario = Verificadora::ExisteUsuario($obj_json)) {
                session_start();
                $_SESSION["nombre"] = $usuario->nombre;
                $_SESSION["perfil"] = $usuario->perfil;
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
            } else {
                $obj = new stdClass();
                $obj->mensaje = "ERROR, correo o clave incorrecta";
                $obj->status = 403;
                $contenidoAPI = json_encode($obj);
            }
        } else if (isset($_SESSION["nombre"]) && isset($_SESSION["perfil"])) {
            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();
        }

        $response = new ResponseMW();
        $response->getBody()->write($contenidoAPI);
        return $response;
    }

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

    public function VerificarAdministrador(Request $request, RequestHandler $handler): ResponseMW
    {
        $metodo = $request->getMethod();
        $contenidoAPI = "";

        if ($metodo === "POST") {
            $nombre_sesion = $_SESSION["nombre"];
            $perfil_sesion = $_SESSION["perfil"];

            if (
                $perfil_sesion === "administrador" ||
                $perfil_sesion === "super_administrador"
            ) {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
            } else {
                $obj = new stdClass();
                $obj->mensaje = "ERROR, usuario '{$nombre_sesion}' sin permisos de administrador";
                $obj->status = 403;
                $contenidoAPI = json_encode($obj);
            }
        } else if ($metodo === "DELETE") {
            $nombre_sesion = $_SESSION["nombre"];
            $perfil_sesion = $_SESSION["perfil"];

            if ($perfil_sesion === "super_administrador") {
                $response = $handler->handle($request);
                $contenidoAPI = (string) $response->getBody();
            } else {
                $obj = new stdClass();
                $obj->mensaje = "ERROR, usuario '{$nombre_sesion}' sin permisos de SUPER administrador";
                $obj->status = 403;
                $contenidoAPI = json_encode($obj);
            }
        } else {
            $response = $handler->handle($request);
            $contenidoAPI = (string) $response->getBody();
        }


        $response = new ResponseMW();
        $response->getBody()->write($contenidoAPI);
        return $response;
    }

    public function CalcularTiempo(Request $request, RequestHandler $handler): ResponseMW
    {
        $contenidoAPI = "";

        $inicio = new DateTime();
        $inicio_mil = round(microtime(true) * 1000);
        // sleep(2); // lantencia harcodeada


        $response = $handler->handle($request);
        $contenidoAPI = (string) $response->getBody();

        $fin = new DateTime();
        $fin_mil = round(microtime(true) * 1000);
        $intervalo_mil = $fin_mil - $inicio_mil;
        $intervalo = $inicio->diff($fin);
        $mensaje = $intervalo->format("Tiempo transcurrido: %s segundos({$intervalo_mil} milisegundos)");

        $response = new ResponseMW();
        $response->getBody()->write($contenidoAPI . $mensaje);
        return $response;
    }

}
