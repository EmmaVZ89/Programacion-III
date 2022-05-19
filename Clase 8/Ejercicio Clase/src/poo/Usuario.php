<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;


require_once "accesoDatos.php";

class Usuario
{
    public int $id;
    public string $nombre;
    public string $apellido;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;
    public string $pathFoto;


    public function TraerTodos(Request $request, Response $response, array $args): Response
    {
        $usuarios = Usuario::traerUsuarios();

        $newResponse = $response->withStatus(200, "OK");
        $newResponse->getBody()->write(json_encode($usuarios));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno(Request $request, Response $response, array $args): Response
    {
        $arrayDeParametros = $request->getParsedBody();

        $correo = $arrayDeParametros["correo"];
        $clave = $arrayDeParametros["clave"];

        $usuario = Usuario::traerUsuario($correo, $clave);
        $login = false;
        $mensaje = "El correo o la contraseña son incorrectos";
        if ($usuario) {
            $login = true;
            $mensaje = "El usuario inicio sesion";
        }

        $obj_respuesta = new stdclass();
        $obj_respuesta->login = $login;
        $obj_respuesta->mensaje = $mensaje;

        $newResponse = $response->withStatus(200, "OK");
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    // METODOS PARA INTERACTUAR CON EL ORIGEN DE LOS DATOS, EN ESTE CASO UNA BASE DE DATOS

    public static function traerUsuarios()
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT u.id, u.nombre, u.apellido, u.correo, 
            u.clave, u.id_perfil, p.descripcion AS perfil, u.foto AS pathFoto
            FROM usuarios u INNER JOIN perfiles p ON u.id_perfil = p.id"
        );
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
    }

    public static function traerUsuario(string $correo, string $clave)
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT u.id, u.nombre, u.apellido, u.correo, 
            u.clave, u.id_perfil, p.descripcion AS perfil, u.foto AS pathFoto
            FROM usuarios u 
            INNER JOIN perfiles p ON u.id_perfil = p.id
            WHERE u.correo = :correo AND u.clave = :clave"
        );
        $consulta->bindValue(":correo", $correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $clave, PDO::PARAM_STR);
        $consulta->execute();

        $usuario = $consulta->fetchObject('Usuario');

        return $usuario;
    }

}
