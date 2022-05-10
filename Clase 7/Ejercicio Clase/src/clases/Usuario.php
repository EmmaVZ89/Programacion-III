<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once "accesoDatos.php";
require_once "ICRUDSLIM.php";

class Usuario implements ICRUDSLIM
{
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    // public function __construct(
    //     int $id = 0,
    //     string $nombre = "",
    //     string $correo = "",
    //     string $clave = "",
    //     int $id_perfil = 0,
    //     string $perfil = ""
    // ) {
    //     $this->id = $id;
    //     $this->nombre = $nombre;
    //     $this->correo = $correo;
    //     $this->clave = $clave;
    //     $this->id_perfil = $id_perfil;
    //     $this->perfil = $perfil;
    // }


    // IMPLEMENTACION DE INTERFACE ICRUDSLIM

    public function ArmarLogin(Request $request, Response $response, array $args): Response
    {
        $html =
            '
      <h4>Login Usuario</h4>
      <form action="http://api_usuarios/usuario/login" method="post">
          <label for="">Correo: </label>
          <input type="text" name="correo" placeholder="ejemplo@email.com" value="luna@mail.com">
          <label for="">Clave: </label>
          <input type="password" name="clave" placeholder="*************" value="123">
          <br><br>
          <input type="submit" value="Iniciar sesion">
      </form>
      ';
        $response->getBody()->write($html);
        return $response;
    }

    public function ArmarPrincipal(Request $request, Response $response, array $args): Response
    {
        session_start();
        if (isset($_SESSION["usuario"])) {
            $html = "<h4>Bienvenido - " . $_SESSION["usuario"] . "</h4><br><br>";
            $html .= "<a href='http://api_usuarios/Salir'>Cerrar sesion</a>";
        } else {
            header("location: http://api_usuarios/");
        }

        $response->getBody()->write($html);
        return $response;
    }

    public function SalirSesion(Request $request, Response $response, array $args): Response
    {
        session_start();
        session_destroy();
        header("location: http://api_usuarios/");
        die();

        // $response->getBody()->write($html);
        return $response;
    }


    public function AgregarUno(Request $request, Response $response, array $args): Response
    {
        $parametros = $request->getParsedBody();

        $obj_respuesta = new stdclass();
        $obj_respuesta->id_nuevo = null;
        $obj_respuesta->mensaje = "No se pudo agregar el usuario";

        if (
            isset($parametros["nombre"]) &&
            isset($parametros["correo"]) &&
            isset($parametros["clave"]) &&
            isset($parametros["id_perfil"])
        ) {
            $nombre = $parametros["nombre"];
            $correo = $parametros["correo"];
            $clave = $parametros["clave"];
            $id_perfil = $parametros["id_perfil"];

            $usuario = new Usuario();
            $usuario->nombre = $nombre;
            $usuario->correo = $correo;
            $usuario->clave = $clave;
            $usuario->id_perfil = $id_perfil;

            $id_agregado = $usuario->agregarUsuario();

            if ($id_agregado) {
                $obj_respuesta->id_nuevo = $id_agregado;
                $obj_respuesta->mensaje = "Usuario Agregado";
            }
        }

        $newResponse = $response->withStatus(200, "OK");
        $newResponse->getBody()->write(json_encode($obj_respuesta));

        return $newResponse->withHeader('Content-Type', 'application/json');
    }

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

        // ################################################################
        if ($usuario) {
            session_start();
            $_SESSION["usuario"] = $usuario->nombre;
            header("location: http://api_usuarios/Principal");
            die();
        }
        // ################################################################

        $newResponse = $response->withStatus(200, "OK");
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno(Request $request, Response $response, array $args): Response
    {
        $obj = json_decode(($args["cadenaJson"]), true);

        $id = $obj["id"];
        $nombre = $obj["nombre"];
        $correo = $obj["correo"];
        $clave = $obj["clave"];
        $id_perfil = $obj["id_perfil"];

        $usuario = new Usuario();
        $usuario->id = $id;
        $usuario->nombre = $nombre;
        $usuario->correo = $correo;
        $usuario->clave = $clave;
        $usuario->id_perfil = $id_perfil;

        $resultado = $usuario->modificarUsuario();

        $obj_respuesta = new stdclass();
        $obj_respuesta->resultado = $resultado;
        $obj_respuesta->mensaje = "No se pudo modificar el usuario";

        if ($resultado) {
            $obj_respuesta->mensaje = "Usuario modificado";
        }

        $newResponse = $response->withStatus(200, "OK");
        $newResponse->getBody()->write(json_encode($obj_respuesta));

        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        $usuario = new Usuario();
        $usuario->id = $id;

        $resultado = $usuario->borrarUsuario();

        $obj_respuesta = new stdclass();
        $obj_respuesta->resultado = $resultado;
        $obj_respuesta->mensaje = "No se pudo borrar el usuario";

        if ($resultado) {
            $obj_respuesta->mensaje = "Usuario borrado";
        }

        $newResponse = $response->withStatus(200, "OK");
        $newResponse->getBody()->write(json_encode($obj_respuesta));

        return $newResponse->withHeader('Content-Type', 'application/json');
    }


    // METODOS PARA INTERACTUAR CON EL ORIGEN DE LOS DATOS, EN ESTE CASO UNA BASE DE DATOS

    public function agregarUsuario()
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta("INSERT INTO usuarios (nombre, correo, clave, id_perfil) "
            . "VALUES(:nombre, :correo, :clave, :id_perfil)");

        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
        $consulta->execute();

        return $accesoDatos->retornarUltimoIdInsertado();
    }

    public static function traerUsuarios()
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT u.id, u.nombre, u.correo, 
            u.clave, u.id_perfil, p.descripcion AS perfil
            FROM usuarios u INNER JOIN perfiles p ON u.id_perfil = p.id"
        );
        $consulta->execute();

        // $array_usuarios = array();
        // while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
        //     $id = $fila["id"];
        //     $nombre = $fila["nombre"];
        //     $correo = $fila["correo"];
        //     $clave = $fila["clave"];
        //     $id_perfil = $fila["id_perfil"];
        //     $perfil = $fila["perfil"];
        //     $usuario = new Usuario($id, $nombre, $correo, $clave, $id_perfil, $perfil);
        //     array_push($array_usuarios, $usuario);
        // }
        // return $array_usuarios;

        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
    }

    public static function traerUsuario(string $correo, string $clave)
    {
        // $usuario = null;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT u.id, u.nombre, u.correo, 
            u.clave, u.id_perfil, p.descripcion AS perfil
            FROM usuarios u 
            INNER JOIN perfiles p ON u.id_perfil = p.id
            WHERE u.correo = :correo AND u.clave = :clave"
        );
        $consulta->bindValue(":correo", $correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $clave, PDO::PARAM_STR);
        $consulta->execute();

        // while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
        //     $id = $fila["id"];
        //     $nombre = $fila["nombre"];
        //     $correo = $fila["correo"];
        //     $clave = $fila["clave"];
        //     $id_perfil = $fila["id_perfil"];
        //     $perfil = $fila["perfil"];
        //     $usuario = new Usuario($id, $nombre, $correo, $clave, $id_perfil, $perfil);
        // }

        $usuario = $consulta->fetchObject('Usuario');

        return $usuario;
    }

    public function modificarUsuario()
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $cadena =
            "UPDATE usuarios SET nombre = :nombre, correo = :correo, clave = :clave, 
        id_perfil = :id_perfil WHERE id = :id";
        $consulta = $accesoDatos->retornarConsulta($cadena);

        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
        $consulta->execute();

        $total_modificado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
        if ($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    public function borrarUsuario()
    {
        $retorno = false;
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta("DELETE FROM usuarios WHERE id = :id");
        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->execute();

        $total_borrado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
        if ($total_borrado == 1) {
            $retorno = true;
        }

        return $retorno;
    }
}
