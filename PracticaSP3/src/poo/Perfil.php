<?php

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once "accesoDatos.php";
require_once "Usuario.php";
require_once __DIR__ . "/autentificadora.php";

class Perfil 
{
    public int $id;
    public string $descripcion;
    public int $estado;


    public function AgregarUno(Request $request, Response $response, array $args): Response
    {
        $parametros = $request->getParsedBody();

        $obj_respuesta = new stdclass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se pudo agregar el perfil";
        $obj_respuesta->status = 418;

        if (isset($parametros["perfil"])) {
            $obj = json_decode($parametros["perfil"]);

            $perfil = new Perfil();
            $perfil->descripcion = $obj->descripcion;
            $perfil->estado = $obj->estado;

            $id_agregado = $perfil->AgregarPerfil();
            $perfil->id = $id_agregado;

            if ($id_agregado) {
                $obj_respuesta->exito = true;
                $obj_respuesta->mensaje = "Perfil Agregado";
                $obj_respuesta->status = 200;
            }
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));

        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos(Request $request, Response $response, array $args): Response
    {
        $obj_respuesta = new stdClass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se encontraron perfiles!";
        $obj_respuesta->dato = "{}";
        $obj_respuesta->status = 424;

        $perfiles = Perfil::TraerPerfiles();

        if (count($perfiles)) {
            $obj_respuesta->exito = true;
            $obj_respuesta->mensaje = "Perfiles encontrados!";
            $obj_respuesta->dato = json_encode($perfiles);
            $obj_respuesta->status = 200;
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno(Request $request, Response $response, array $args): Response
    {
        $obj_respuesta = new stdclass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se pudo borrar el perfil";
        $obj_respuesta->status = 418;

        if (
            isset($request->getHeader("token")[0]) &&
            isset($args["id_perfil"])
        ) {
            $token = $request->getHeader("token")[0];
            $id = $args["id_perfil"];

            $datos_token = Autentificadora::obtenerPayLoad($token);
            $usuario_token = $datos_token->payload->data;
            $perfil_usuario = $usuario_token->id_perfil;// 1- propietario, 2- encargado, 3- empleado

            if ($perfil_usuario == 1) {
                if (Perfil::BorrarPerfil($id)) {
                    $obj_respuesta->exito = true;
                    $obj_respuesta->mensaje = "Perfil Borrado!";
                    $obj_respuesta->status = 200;
                } else {
                    $obj_respuesta->mensaje = "El Perfil no existe en el listado!";
                }
            } else {
                $obj_respuesta->mensaje = "Usuario no autorizado para realizar la accion. {$usuario_token->nombre} - {$usuario_token->apellido} - {$usuario_token->id_perfil}";
            }
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno(Request $request, Response $response, array $args): Response
    {
        $obj_respuesta = new stdclass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se pudo modificar el perfil";
        $obj_respuesta->status = 418;

        if (
            isset($request->getHeader("token")[0]) &&
            isset($args["id_perfil"]) &&
            isset($args["perfil"])
        ) {
            $token = $request->getHeader("token")[0];
            $id = $args["id_perfil"];
            $obj_json = json_decode($args["perfil"]);

            $datos_token = Autentificadora::obtenerPayLoad($token);
            $usuario_token = $datos_token->payload->data;
            $perfil_usuario = $usuario_token->id_perfil;// 1- propietario, 2- encargado, 3- empleado

            if ($perfil_usuario == 2) {
                if ($perfil = Perfil::TraerPerfilPorId($id)) {
                    $perfil->descripcion = $obj_json->descripcion;
                    $perfil->estado = $obj_json->estado;
                    if ($perfil->ModificarPerfil()) {
                        $obj_respuesta->exito = true;
                        $obj_respuesta->mensaje = "Perfil Modificado!";
                        $obj_respuesta->status = 200;
                    } else {
                    }
                } else {
                    $obj_respuesta->mensaje = "El Perfil no existe en el listado!";
                }
            } else {
                $obj_respuesta->mensaje = "Usuario no autorizado para realizar la accion. {$usuario_token->nombre} - {$usuario_token->apellido} - {$usuario_token->id_perfil}";
            }
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    
    // METODOS PARA INTERACTUAR CON EL ORIGEN DE LOS DATOS, EN ESTE CASO UNA BASE DE DATOS

    public function AgregarPerfil()
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "INSERT INTO perfiles (descripcion, estado) 
             VALUES(:descripcion, :estado)"
        );

        $consulta->bindValue(":descripcion", $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(":estado", $this->estado, PDO::PARAM_INT);
        $consulta->execute();

        return $accesoDatos->retornarUltimoIdInsertado();
    }

    public static function TraerPerfiles()
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM perfiles"
        );
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, "Perfil");
    }

    public static function TraerPerfilPorId(int $id)
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM perfiles 
             WHERE id = :id"
        );
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $perfil = $consulta->fetchObject('Perfil');

        return $perfil;
    }

    public static function BorrarPerfil(int $id)
    {
        $retorno = false;
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta("DELETE FROM perfiles WHERE id = :id");
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $total_borrado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
        if ($total_borrado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    public function ModificarPerfil()
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "UPDATE perfiles
             SET descripcion = :descripcion, estado = :estado
             WHERE id = :id"
        );

        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":descripcion", $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(":estado", $this->estado, PDO::PARAM_INT);
        $consulta->execute();

        $total_modificado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
        if ($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }
}
