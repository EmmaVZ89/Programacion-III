<?php
namespace Zelarayan;
require_once("./clases/IBM.php");
use PDO;
use stdClass;

class Usuario implements IBM
{
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    public function __construct(
        int $id = 0,
        string $nombre = "",
        string $correo = "",
        string $clave = "",
        int $id_perfil = 0,
        string $perfil = ""
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $id_perfil;
        $this->perfil = $perfil;
    }

    public function ToJSON(): string
    {
        $retorno = array("nombre" => $this->nombre, "correo" => $this->correo, "clave" => $this->clave);
        return json_encode($retorno);
    }

    public function GuardarEnArchivo(): string
    {
        $exito = false;
        $mensaje = "No se pudo guardar el Usuario";
        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/usuarios.json", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->ToJSON()},\r\n");
        if ($cant > 0) {
            $exito = true;
            $mensaje = "Usuario Guardado con exito";
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        //Creo array asociativo para luego parsearlo a JSON
        $retorno = array("exito" => $exito, "mensaje" => $mensaje);

        return json_encode($retorno);
    }

    public static function TraerTodosJSON(): array
    {
        $array_usuarios = array();

        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/usuarios.json", "r");
        $contenido = "";
        //LEO LINEA X LINEA DEL ARCHIVO 
        while (!feof($ar)) {
            $contenido .= fgets($ar);
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        $array_contenido = explode(",\r\n", $contenido);

        for ($i = 0; $i < count($array_contenido); $i++) {
            if ($array_contenido[$i] != "") {
                $usuarioJson = json_decode($array_contenido[$i], true);
                $usuario = new Usuario(0, $usuarioJson["nombre"], $usuarioJson["correo"], $usuarioJson["clave"]);
                array_push($array_usuarios, $usuario);
                // array_push($array_usuarios, json_decode($array_contenido[$i], true));
            }
        }

        return $array_usuarios;
    }

    public function Agregar(): bool
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta("INSERT INTO usuarios (nombre, correo, clave, id_perfil) "
            . "VALUES(:nombre, :correo, :clave, :id_perfil)");

        // $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);

        $retorno = $consulta->execute();

        return $retorno;
    }

    public static function TraerTodos(): array
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM usuarios u INNER JOIN perfiles p ON u.id_perfil = p.id"
        );
        $consulta->execute();
        // $consulta->setFetchMode(PDO::FETCH_INTO, new Usuario);

        $array_usuarios = array();
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new stdClass();
            $usuario->id = $fila["id"];
            $usuario->nombre = $fila["nombre"];
            $usuario->correo = $fila["correo"];
            $usuario->clave = $fila["clave"];
            $usuario->id_perfil = $fila["id_perfil"];
            $usuario->perfil = $fila["descripcion"];
            array_push($array_usuarios, $usuario);
        }

        return $array_usuarios;
        // return $consulta;
    }

    public static function TraerUno($params)
    {
        $usuario = null;
        $parametros = json_decode($params, true);

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM usuarios u INNER JOIN perfiles p ON u.id_perfil = p.id
         WHERE u.correo = :correo AND u.clave = :clave"
        );
        $consulta->bindValue(":correo", $parametros["correo"], PDO::PARAM_STR);
        $consulta->bindValue(":clave", $parametros["clave"], PDO::PARAM_STR);
        $consulta->execute();

        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $id = $fila["id"];
            $nombre = $fila["nombre"];
            $correo = $fila["correo"];
            $clave = $fila["clave"];
            $id_perfil = $fila["id_perfil"];
            $perfil = $fila["descripcion"];
            $usuario = new Usuario($id, $nombre, $correo, $clave, $id_perfil, $perfil);
        }

        return $usuario;
    }


    // IMPLEMENTACION DE INTERFACE IBM

    public function Modificar() : bool
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

        $total_modificado = $consulta->rowCount();
        if($total_modificado == 1) {
            $retorno = true;
        }

        // $consultaOK = $consulta->execute();
        // $param = array("correo"=>$this->correo, "clave"=>$this->clave);
        // $usuario = Usuario::TraerUno(json_encode($param));
        // if ($consultaOK && $usuario) {
        //     $retorno = true;
        // }

        return $retorno;
    }

    public static function Eliminar(int $id) : bool
    {
        $retorno = false;
		$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
		$consulta = $accesoDatos->retornarConsulta("DELETE FROM usuarios WHERE id = :id");
		$consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();
        
        $total_borrado = $consulta->rowCount();
        if($total_borrado == 1) {
            $retorno = true;
        }

        // $param = array("correo"=>$this->correo, "clave"=>$this->clave);
        // $usuario = Usuario::TraerUno(json_encode($param));
		// if(Alumno::validarAlumno($legajo)){
		// 	$pathImg = Alumno::obtenerAlumno($legajo)->foto;
		// 	if($consulta->execute()) {
		// 		$retorno = true;
		// 		unlink($pathImg);
		// 	}
		// }

		return $retorno;
    }


}


// http://localhost/Programacion-III/Clase 6 Modelo PP