<?php
namespace Zelarayan;
// require_once("./clases/IBM.php");
// use PDO;
// use stdClass;

class Usuario
{
    private string $email;
    private string $clave;

    public function __construct(
        string $email = "",
        string $clave = ""
    ) {
        $this->email = $email;
        $this->clave = $clave;
    }

    public function GetEmail():string {
        return $this->email;
    }

    public function GetClave():string {
        return $this->clave;
    }

    public function ToString(): string
    {
        return "{$this->email} - {$this->clave}";
    }

    public function GuardarEnArchivo(): string
    {
        $mensaje = "No se pudo guardar el Usuario";
        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/usuarios.txt", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->ToString()},\r\n");
        if ($cant > 0) {
            $mensaje = "Usuario Guardado con exito";
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        return $mensaje;
    }

    public static function TraerTodos(): array
    {
        $array_usuarios = array();

        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/usuarios.txt", "r");
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
                $usuario_array = explode("-", $array_contenido[$i]);
                $email = trim($usuario_array[0]);
                $clave = trim($usuario_array[1]);
                $usuario = new Usuario($email, $clave);
                array_push($array_usuarios, $usuario);
            }
        }

        return $array_usuarios;
    }

    public static function VerificarExistencia(Usuario $usuario) : bool {
        $retorno = false;
		$usuarios = Usuario::TraerTodos();

        for ($i=0; $i < count($usuarios) ; $i++) { 
            if($usuarios[$i]->GetEmail() == $usuario->GetEmail() &&
            $usuarios[$i]->GetClave() == $usuario->GetClave()) {
                $retorno = true;
                break;
            }
        }
		return $retorno;
    }






    // public function Agregar(): bool
    // {
    //     $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

    //     $consulta = $accesoDatos->retornarConsulta("INSERT INTO usuarios (nombre, correo, clave, id_perfil) "
    //         . "VALUES(:nombre, :correo, :clave, :id_perfil)");

    //     // $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
    //     $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
    //     $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
    //     $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
    //     $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);

    //     $retorno = $consulta->execute();

    //     return $retorno;
    // }

    // public static function TraerTodos(): array
    // {
    //     $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
    //     $consulta = $accesoDatos->retornarConsulta(
    //         "SELECT * FROM usuarios u INNER JOIN perfiles p ON u.id_perfil = p.id"
    //     );
    //     $consulta->execute();

    //     $array_usuarios = array();
    //     while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
    //         $id = $fila["id"];
    //         $nombre = $fila["nombre"];
    //         $correo = $fila["correo"];
    //         $clave = $fila["clave"];
    //         $id_perfil = $fila["id_perfil"];
    //         $perfil = $fila["descripcion"];
    //         $usuario = new Usuario($id, $nombre, $correo, $clave, $id_perfil, $perfil);
    //         array_push($array_usuarios, $usuario);
    //     }

    //     return $array_usuarios;
    // }

    // public static function TraerUno($params)
    // {
    //     $usuario = null;
    //     $parametros = json_decode($params, true);

    //     $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
    //     $consulta = $accesoDatos->retornarConsulta(
    //         "SELECT * FROM usuarios u INNER JOIN perfiles p ON u.id_perfil = p.id
    //      WHERE u.correo = :correo AND u.clave = :clave"
    //     );
    //     $consulta->bindValue(":correo", $parametros["correo"], PDO::PARAM_STR);
    //     $consulta->bindValue(":clave", $parametros["clave"], PDO::PARAM_STR);
    //     $consulta->execute();

    //     while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
    //         $id = $fila["id"];
    //         $nombre = $fila["nombre"];
    //         $correo = $fila["correo"];
    //         $clave = $fila["clave"];
    //         $id_perfil = $fila["id_perfil"];
    //         $perfil = $fila["descripcion"];
    //         $usuario = new Usuario($id, $nombre, $correo, $clave, $id_perfil, $perfil);
    //     }

    //     return $usuario;
    // }


    // // IMPLEMENTACION DE INTERFACE IBM

    // public function Modificar() : bool
    // {
    //     $retorno = false;

    //     $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

    //     $cadena = 
    //     "UPDATE usuarios SET nombre = :nombre, correo = :correo, clave = :clave, 
    //     id_perfil = :id_perfil WHERE id = :id";
    //     $consulta = $accesoDatos->retornarConsulta($cadena);

    //     $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
    //     $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
    //     $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
    //     $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
    //     $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
    //     $consulta->execute();

    //     $total_modificado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
    //     if($total_modificado == 1) {
    //         $retorno = true;
    //     }

    //     return $retorno;
    // }

    // public static function Eliminar(int $id) : bool
    // {
    //     $retorno = false;
	// 	$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
	// 	$consulta = $accesoDatos->retornarConsulta("DELETE FROM usuarios WHERE id = :id");
	// 	$consulta->bindValue(":id", $id, PDO::PARAM_INT);
    //     $consulta->execute();
        
    //     $total_borrado = $consulta->rowCount(); // verifico las filas afectadas por la consulta
    //     if($total_borrado == 1) {
    //         $retorno = true;
    //     }

	// 	return $retorno;
    // }


}


// http://localhost/Programacion-III/Clase 6 Modelo PP