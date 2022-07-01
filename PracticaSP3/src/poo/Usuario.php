<?php

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once "accesoDatos.php";
require_once __DIR__ . "/autentificadora.php";

class Usuario
{
    public int $id;
    public string $correo;
    public string $clave;
    public string $nombre;
    public string $apellido;
    public string $id_perfil;
    public string $foto;


    public function AgregarUno(Request $request, Response $response, array $args): Response
    {
        $parametros = $request->getParsedBody();

        $obj_respuesta = new stdclass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se pudo agregar el usuario";
        $obj_respuesta->status = 418;

        if (isset($parametros["usuario"])) {
            $obj = json_decode($parametros["usuario"]);

            $usuario = new Usuario();
            $usuario->correo = $obj->correo;
            $usuario->clave = $obj->clave;
            $usuario->nombre = $obj->nombre;
            $usuario->apellido = $obj->apellido;
            $usuario->id_perfil = $obj->id_perfil;
            $usuario->foto = "";

            $id_agregado = $usuario->AgregarUsuario();
            $usuario->id = $id_agregado;

            $foto = "";
            //#####################################################
            // Guardado de foto/archivo
            if (count($request->getUploadedFiles())) {
                $archivos = $request->getUploadedFiles();
                $destino = "./src/fotos/";

                $nombreAnterior = $archivos['foto']->getClientFilename();
                $extension = explode(".", $nombreAnterior);
                $extension = array_reverse($extension);

                $foto = $destino . $id_agregado . "_" . $usuario->apellido . "." . $extension[0];
                $archivos['foto']->moveTo("." . $foto); // OjO agregue un punto .
                $usuario->foto = $foto;
                $usuario->ModificarUsuario();
            }
            //#####################################################

            if ($id_agregado) {
                $obj_respuesta->exito = true;
                $obj_respuesta->mensaje = "Usuario Agregado";
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
        $obj_respuesta->mensaje = "No se encontraron usuarios!";
        $obj_respuesta->dato = "{}";
        $obj_respuesta->status = 424;

        $usuarios = Usuario::TraerUsuarios();

        if (count($usuarios)) {
            $obj_respuesta->exito = true;
            $obj_respuesta->mensaje = "Usuarios encontrados!";
            $obj_respuesta->dato = json_encode($usuarios);
            $obj_respuesta->status = 200;
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function VerificarUsuario(Request $request, Response $response, array $args): Response
    {
        $arrayDeParametros = $request->getParsedBody();
        $obj_respuesta = new stdClass();
        $obj_respuesta->exito = false;
        $obj_respuesta->jwt = null;
        $obj_respuesta->status = 403;

        if (isset($arrayDeParametros["user"])) {
            $obj = json_decode($arrayDeParametros["user"]);
            if ($usuario = Usuario::TraerUsuario($obj)) {
                $data = new stdClass();
                $data->id = $usuario->id;
                $data->correo = $usuario->correo;
                $data->nombre = $usuario->nombre;
                $data->apellido = $usuario->apellido;
                $data->id_perfil = $usuario->id_perfil;
                $data->foto = $usuario->foto;

                $obj_respuesta->exito = true;
                $obj_respuesta->jwt =  Autentificadora::crearJWT($data, 1800);
                $obj_respuesta->status = 200;
            }
        }

        $contenidoAPI = json_encode($obj_respuesta);
        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ChequearJWT(Request $request, Response $response, array $args): Response
    {
        $contenidoAPI = "";
        $obj_respuesta = new stdClass();
        $obj_respuesta->mensaje = "Token Invalido!";
        $obj_respuesta->status = 403;

        if (isset($request->getHeader("token")[0])) {
            $token = $request->getHeader("token")[0];

            $obj = Autentificadora::verificarJWT($token);

            if ($obj->verificado) {
                $obj_respuesta->mensaje = $obj->mensaje;
                $obj_respuesta->status = 200;
            }
        }

        $contenidoAPI = json_encode($obj_respuesta);

        $response = $response->withStatus($obj_respuesta->status);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno(Request $request, Response $response, array $args): Response
    {
        $obj_respuesta = new stdclass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se pudo borrar el usuario";
        $obj_respuesta->status = 418;

        if (
            isset($request->getHeader("token")[0]) &&
            isset($args["id_usuario"])
        ) {
            $token = $request->getHeader("token")[0];
            $id = $args["id_usuario"];

            $datos_token = Autentificadora::obtenerPayLoad($token);
            $usuario_token = $datos_token->payload->data;
            $perfil_usuario = $usuario_token->id_perfil; // 1- propietario, 2- encargado, 3- empleado

            if ($perfil_usuario == 1) {
                if (Usuario::BorrarUsuario($id)) {
                    $obj_respuesta->exito = true;
                    $obj_respuesta->mensaje = "Usuario Borrado!";
                    $obj_respuesta->status = 200;
                } else {
                    $obj_respuesta->mensaje = "El Usuario no existe en el listado!";
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
        $parametros = $request->getParsedBody();

        $obj_respuesta = new stdclass();
        $obj_respuesta->exito = false;
        $obj_respuesta->mensaje = "No se pudo modificar el usuario";
        $obj_respuesta->status = 418;

        if (
            isset($request->getHeader("token")[0]) &&
            isset($parametros["usuario"])
        ) {
            $token = $request->getHeader("token")[0];
            $obj_json = json_decode($parametros["usuario"]);

            $datos_token = Autentificadora::obtenerPayLoad($token);
            $usuario_token = $datos_token->payload->data;
            $perfil_usuario = $usuario_token->id_perfil; // 1- propietario, 2- encargado, 3- empleado

            if ($perfil_usuario == 2) {
                if ($usuario = Usuario::TraerUsuarioPorId($obj_json->id)) {
                    $usuario->correo = $obj_json->correo;
                    $usuario->clave = $obj_json->clave;
                    $usuario->nombre = $obj_json->nombre;
                    $usuario->apellido = $obj_json->apellido;
                    $usuario->id_perfil = $obj_json->id_perfil;

                    $foto = "";
                    //#####################################################
                    // Guardado de foto/archivo
                    if (count($request->getUploadedFiles())) {
                        $archivos = $request->getUploadedFiles();
                        $destino = "./src/fotos/";

                        $nombreAnterior = $archivos['foto']->getClientFilename();
                        $extension = explode(".", $nombreAnterior);
                        $extension = array_reverse($extension);

                        $foto = $destino . $usuario->id . "_" . $usuario->apellido . "." . $extension[0];
                        $archivos['foto']->moveTo("." . $foto); // OjO agregue un punto .
                        $usuario->foto = $foto;
                    }
                    //#####################################################

                    if ($usuario->ModificarUsuario()) {
                        $obj_respuesta->exito = true;
                        $obj_respuesta->mensaje = "Usuario Modificado!";
                        $obj_respuesta->status = 200;
                    } else {
                    }
                } else {
                    $obj_respuesta->mensaje = "El Usuario no existe en el listado!";
                }
            } else {
                $obj_respuesta->mensaje = "Usuario no autorizado para realizar la accion. {$usuario_token->nombre} - {$usuario_token->apellido} - {$usuario_token->id_perfil}";
            }
        }

        $newResponse = $response->withStatus($obj_respuesta->status);
        $newResponse->getBody()->write(json_encode($obj_respuesta));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    // PDF
    public function ListarPdf(Request $request, Response $response, array $args): Response
    {
        $contenidoAPI = "";

        if (isset($request->getHeader("token")[0])) {
            $token = $request->getHeader("token")[0];
            // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NTUwODYxMDQsImV4cCI6MTY1NTA4NzkwNCwiYXVkIjoie1wiaXBfdmlzaXRhbnRlXCI6XCIxMjcuMC4wLjFcIixcInVzZXJfYWdlbnRcIjpcIlRodW5kZXIgQ2xpZW50IChodHRwczpcXFwvXFxcL3d3dy50aHVuZGVyY2xpZW50LmNvbSlcIixcImhvc3RfbmFtZVwiOlwiREVTS1RPUC1FUkpNVDA3XCJ9IiwiZGF0YSI6eyJpZCI6MywiY29ycmVvIjoic29sZUBtYWlsLmNvbSIsIm5vbWJyZSI6IlNvbGVkYWQiLCJhcGVsbGlkbyI6IlBlcmV6IiwiaWRfcGVyZmlsIjoiMiIsImZvdG8iOiIuXC9zcmNcL2ZvdG9zXC8zX1BlcmV6LmpwZyJ9LCJhcHAiOiJBUEkgVVNVQVJJTyAyMDIyIn0.xjRmC6qop-WocUuBVAJalu0jOKZw2RYp4WceCAwAr4U";
            $listado = Usuario::TraerUsuarios();
            $pass = "1234";

            $datos_token = Autentificadora::obtenerPayLoad($token);
            $usuario_token = $datos_token->payload->data;
            $perfil_usuario = $usuario_token->id_perfil; // 1- propietario, 2- encargado, 3- empleado

            if ($perfil_usuario == 3) {
                $pass = $usuario_token->apellido;
            } else {
                $pass = $usuario_token->correo;
            }

            // PDF ****************************************************************************
            header('content-type:application/pdf');
            $mpdf = new \Mpdf\Mpdf([
                'orientation' => 'P',
                'pagenumPrefix' => 'Página nro. ',
                'pagenumSuffix' => ' - ',
                'nbpgPrefix' => ' de ',
                'nbpgSuffix' => ' páginas'
            ]); //P-> vertical; L-> horizontal

            $mpdf->SetProtection(array(), $pass, 'mipass');

            $mpdf->SetHeader('Zelarayan Emmanuel||{PAGENO}{nbpg}');
            //alineado izquierda | centro | alineado derecha
            $mpdf->SetFooter('|{DATE j-m-Y}|');

            $mpdf->WriteHTML("<h3>Listado de Usuarios</h3>");
            $mpdf->WriteHTML("<br>");
            $mpdf->WriteHTML(Usuario::ArmarTabla($listado));

            $mpdf->Output("usuarios.pdf", 'I');
            // PDF ****************************************************************************
        }

        $response = $response->withStatus(200);
        $response->getBody()->write($contenidoAPI);
        return $response->withHeader('Content-Type', 'application/json');
    }

    private static function ArmarTabla($listado): string
    {
        $tabla = "<table><thead><tr>";
        foreach ($listado[0] as $key => $value) {
            $tabla .= "<th>{$key}</th>";
        }
        $tabla .= "</tr></thead><tbody>";

        foreach ($listado as $item) {
            $tabla .= "<tr>";
            foreach ($item as $key => $value) {
                if ($key == "foto") {
                    $tabla .= "<td><img src='{$value}' width=25px></td>";
                } else {
                    $tabla .= "<td>{$value}</td>";
                }
            }
            $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table> <br>";
        return $tabla;
    }

    // METODOS PARA INTERACTUAR CON EL ORIGEN DE LOS DATOS, EN ESTE CASO UNA BASE DE DATOS

    public function AgregarUsuario()
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "INSERT INTO usuarios (correo, clave, nombre, apellido, id_perfil, foto) 
             VALUES(:correo, :clave, :nombre, :apellido, :id_perfil, :foto)"
        );

        $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
        $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);
        $consulta->execute();

        return $accesoDatos->retornarUltimoIdInsertado();
    }

    public static function TraerUsuarios()
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM usuarios"
        );
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
    }

    public static function TraerUsuario($obj)
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM usuarios
             WHERE correo = :correo AND clave = :clave"
        );
        $consulta->bindValue(":correo", $obj->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $obj->clave, PDO::PARAM_STR);
        $consulta->execute();

        $usuario = $consulta->fetchObject('Usuario');

        return $usuario;
    }

    public static function TraerUsuarioPorId($id)
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM usuarios
             WHERE id = :id"
        );
        $consulta->bindValue(":id", $id, PDO::PARAM_STR);
        $consulta->execute();

        $usuario = $consulta->fetchObject('Usuario');

        return $usuario;
    }

    public function ModificarUsuario()
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "UPDATE usuarios
             SET correo = :correo, clave = :clave, nombre = :nombre,
             apellido = :apellido, id_perfil = :id_perfil, foto = :foto
             WHERE id = :id"
        );

        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
        $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);
        $consulta->execute();

        $total_modificado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
        if ($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    public static function BorrarUsuario(int $id)
    {
        $retorno = false;
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta("DELETE FROM usuarios WHERE id = :id");
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $total_borrado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
        if ($total_borrado == 1) {
            $retorno = true;
        }

        return $retorno;
    }
}
