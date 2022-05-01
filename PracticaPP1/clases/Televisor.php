<?php

namespace Zelarayan;

require_once("./clases/IParte2.php");
require_once("./clases/IParte3.php");
require_once("./clases/IParte4.php");

use PDO;
use stdClass;

class Televisor implements IParte2, IParte3, IParte4
{
    public string $tipo;
    public int $precio;
    public string $paisOrigen;
    public string $path;

    public function __construct(string $tipo = "", int $precio = 0, string $paisOrigen = "", string $path = "")
    {
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->paisOrigen = $paisOrigen;
        $this->path = $path;
    }

    public function ToString(): string
    {
        return "{$this->tipo} - {$this->precio} - {$this->paisOrigen} - {$this->path}";
    }

    public static function MostrarBorrados() : array
    {
        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/televisores_borrados.txt", "r");
        $contenido = "";
        //LEO LINEA X LINEA DEL ARCHIVO 
        while (!feof($ar)) {
            $contenido .= fgets($ar);
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        $array_televisores = array();
        $array_contenido = explode(",\r\n", $contenido);
        for ($i = 0; $i < count($array_contenido); $i++) {
            if ($array_contenido[$i] != "") {
                $televisor_array = explode("-", $array_contenido[$i]);
                $tipo = trim($televisor_array[0]);
                $precio = (int) trim($televisor_array[1]);
                $paisOrigen = trim($televisor_array[2]);
                $path = trim($televisor_array[3]);
                $televisor = new Televisor($tipo, $precio, $paisOrigen, $path);
                array_push($array_televisores, $televisor);
            }
        }

        return $array_televisores;
    }

    // IMPLEMENTACION DE INTERFACE IPARTE2
    public function Agregar(): bool
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "INSERT INTO televisores (tipo, precio, paisOrigen, path) "
                . "VALUES(:tipo, :precio, :paisOrigen, :path)"
        );

        $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(":paisOrigen", $this->paisOrigen, PDO::PARAM_STR);
        $consulta->bindValue(":path", $this->path, PDO::PARAM_STR);

        $retorno = $consulta->execute();

        return $retorno;
    }

    public static function Traer(): array
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM televisores"
        );
        $consulta->execute();

        $array_televisores = array();
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $tipo = $fila["tipo"];
            $precio = $fila["precio"];
            $paisOrigen = $fila["paisOrigen"];
            $path = $fila["path"];
            $televisor = new Televisor($tipo, $precio, $paisOrigen, $path);
            array_push($array_televisores, $televisor);
        }

        return $array_televisores;
    }

    public function CalcularIVA(): float
    {
        return (float)($this->precio * 1.21);
    }

    public function Verificar(array $televisores): bool
    {
        $retorno = true;

        for ($i = 0; $i < count($televisores); $i++) {
            if (
                $televisores[$i]->tipo == $this->tipo &&
                $televisores[$i]->paisOrigen == $this->paisOrigen
            ) {
                $retorno = false;
                break;
            }
        }

        return $retorno;
    }

    // IMPLEMENTACION DE INTERFACE IPARTE3
    public function Modificar(): bool
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $cadena =
            "UPDATE televisores SET precio = :precio, path = :path
         WHERE paisOrigen = :paisOrigen AND tipo = :tipo"; // no lo modifico por Id
        $consulta = $accesoDatos->retornarConsulta($cadena);

        $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(":paisOrigen", $this->paisOrigen, PDO::PARAM_STR);
        $consulta->bindValue(":path", $this->path, PDO::PARAM_STR);
        $consulta->execute();

        $total_modificado = $consulta->rowCount();
        if ($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    // IMPLEMENTACION DE INTERFACE IPARTE4
    public function Eliminar(): bool
    {
        $retorno = false;
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "DELETE FROM televisores WHERE tipo = :tipo AND paisOrigen = :paisOrigen"
        );
        $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(":paisOrigen", $this->paisOrigen, PDO::PARAM_STR);
        $consulta->execute();

        $total_borrado = $consulta->rowCount();
        if ($total_borrado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    public function GuardarEnArchivo()
    {
        $path_actual = $this->path;
        $tipoArchivo = pathinfo($path_actual, PATHINFO_EXTENSION);
        $path_destino = "./televisoresBorrados/" .
            $this->tipo . ".borrado." . date("G") . date("i") . date("s") . $tipoArchivo;
        copy($path_actual, $path_destino);
        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/televisores_borrados.txt", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->tipo} - {$this->precio} - {$this->paisOrigen} - {$path_destino},\r\n");
        if ($cant > 0) {
            unlink($path_actual);
        }
        //CIERRO EL ARCHIVO
        fclose($ar);
    }
}
