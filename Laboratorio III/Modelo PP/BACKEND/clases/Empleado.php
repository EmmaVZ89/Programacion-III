<?php
namespace Zelarayan;
require_once("./clases/ICRUD.php");
require_once("./clases/Usuario.php");
use PDO;
use stdClass;

class Empleado extends Usuario implements ICRUD {
    public string $foto;
    public int $sueldo;

    public function __construct(
        int $id = 0,
        string $nombre = "",
        string $correo = "",
        string $clave = "",
        int $id_perfil = 0,
        string $perfil = "",
        string $foto = "",
        int $sueldo = 0
        )
	{
		parent::__construct($id,$nombre,$correo,$clave,$id_perfil,$perfil);
		$this->foto = $foto;
        $this->sueldo = $sueldo;
	}

    // IMPLEMENTACION DE INTERFACE ICRUD
    public static function TraerTodos(): array
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
        "SELECT e.id, e.nombre, e.correo,
        e.clave, e.id_perfil, e.foto, e.sueldo, p.descripcion
         FROM empleados e INNER JOIN perfiles p ON e.id_perfil = p.id"
        );
        $consulta->execute();

        $array_empleados = array();
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $id = $fila["id"];
            $nombre = $fila["nombre"];
            $correo = $fila["correo"];
            $clave = $fila["clave"];
            $id_perfil = $fila["id_perfil"];
            $perfil = $fila["descripcion"];
            $foto = $fila["foto"];
            $sueldo = $fila["sueldo"];
            $empleado = new Empleado($id,$nombre,$correo,$clave,$id_perfil,$perfil,$foto,$sueldo);
            array_push($array_empleados, $empleado);
        }

        return $array_empleados;
    }

    public function Agregar(): bool
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "INSERT INTO empleados (nombre, correo, clave, id_perfil, foto, sueldo) "
            . "VALUES(:nombre, :correo, :clave, :id_perfil, :foto, :sueldo)"
        );

        // $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
        $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(":sueldo", $this->sueldo, PDO::PARAM_INT);

        $retorno = $consulta->execute();
        
        return $retorno;

    }

    public function Modificar(): bool
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $cadena = 
        "UPDATE empleados SET nombre = :nombre, correo = :correo, clave = :clave, 
        id_perfil = :id_perfil, foto = :foto, sueldo = :sueldo WHERE id = :id";
        $consulta = $accesoDatos->retornarConsulta($cadena);

        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
        $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(":sueldo", $this->sueldo, PDO::PARAM_INT);
        $consulta->execute();

        $total_modificado = $consulta->rowCount();
        if($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    public static function Eliminar(int $id): bool
    {
        $retorno = false;
		$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
		$consulta = $accesoDatos->retornarConsulta("DELETE FROM empleados WHERE id = :id");
		$consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();
        
        $total_borrado = $consulta->rowCount();
        if($total_borrado == 1) {
            $retorno = true;
        }

		return $retorno;
    }


}


?>