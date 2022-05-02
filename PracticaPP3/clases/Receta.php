<?php
namespace Zelarayan;
require_once("./clases/IParte1.php");
require_once("./clases/IParte2.php");
require_once("./clases/IParte3.php");

use PDO;
use stdClass;

class Receta implements IParte1, IParte2, IParte3
{
    public int $id;
    public string $nombre;
    public string $ingredientes;
    public string $tipo;
    public string $pathFoto;

    public function __construct(
        int $id = 0,
        string $nombre = "",
        string $ingredientes = "",
        string $tipo = "",
        string $pathFoto = ""
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ingredientes = $ingredientes;
        $this->tipo = $tipo;
        $this->pathFoto = $pathFoto;
    }

    public function ToJSON(): string
    {
        $retorno = array(
            "id" => $this->id,
            "nombre" => $this->nombre,
            "ingredientes" => $this->ingredientes,
            "tipo" => $this->tipo,
            "pathFoto" => $this->pathFoto
        );
        return json_encode($retorno);
    }

    public static function TraerReceta(int $id) {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM recetas WHERE id = :id"
        );
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $receta = null;
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $id = $fila["id"];
            $nombre = $fila["nombre"];
            $ingredientes = $fila["ingredientes"];
            $tipo = $fila["tipo"];
            $pathFoto = $fila["pathFoto"];
            $receta = new Receta(
                $id,
                $nombre,
                $ingredientes,
                $tipo,
                $pathFoto
            );
        }

        return $receta;
    }

    public static function MostrarBorrados(): array
    {
        $path = "./archivos/recetas_borradas.txt";
        $array_recetas = array();

        if(file_exists($path)) {
            $ar = fopen($path, "r");
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
                    $obj = json_decode($array_contenido[$i], true);
                    $id = $obj["id"];
                    $nombre = $obj["nombre"];
                    $ingredientes = $obj["ingredientes"];
                    $tipo = $obj["tipo"];
                    $pathFoto = $obj["pathFoto"];
                    $receta = new Receta($id,$nombre,$ingredientes,$tipo,$pathFoto);
                    array_push($array_recetas, $receta);
                }
            }
        
        }
        
        return $array_recetas;
    }

    // IMPLEMENTACION DE INTERFACE IParte1
    public function Agregar(): bool
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "INSERT INTO recetas (nombre, ingredientes, tipo, pathFoto) "
                . "VALUES(:nombre, :ingredientes, :tipo, :pathFoto)"
        );

        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":ingredientes", $this->ingredientes, PDO::PARAM_STR);
        $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(":pathFoto", $this->pathFoto, PDO::PARAM_STR);

        $retorno = $consulta->execute();

        return $retorno;
    }

    public static function Traer(): array
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM recetas"
        );
        $consulta->execute();

        $array_recetas = array();
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $id = $fila["id"];
            $nombre = $fila["nombre"];
            $ingredientes = $fila["ingredientes"];
            $tipo = $fila["tipo"];
            $pathFoto = $fila["pathFoto"];
            $receta = new Receta(
                $id,
                $nombre,
                $ingredientes,
                $tipo,
                $pathFoto
            );
            array_push($array_recetas, $receta);
        }

        return $array_recetas;
    }

    // IMPLEMENTACION DE INTERFACE IParte2
    public function Existe(array $recetas): bool
    {
        $retorno = false;
        for ($i = 0; $i < count($recetas); $i++) {
            if (
                $recetas[$i]->nombre == $this->nombre &&
                $recetas[$i]->tipo == $this->tipo
            ) {
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    public function Modificar(): bool
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $cadena =
            "UPDATE recetas SET nombre = :nombre, ingredientes = :ingredientes, tipo = :tipo, 
        pathFoto = :pathFoto WHERE id = :id";
        $consulta = $accesoDatos->retornarConsulta($cadena);

        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":ingredientes", $this->ingredientes, PDO::PARAM_STR);
        $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(":pathFoto", $this->pathFoto, PDO::PARAM_STR);
        $consulta->execute();

        $total_modificado = $consulta->rowCount();
        if ($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    // IMPLEMENTACION DE INTERFACE IParte3
    public function Eliminar(): bool
    {
        $retorno = false;
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
        "DELETE FROM recetas WHERE nombre = :nombre AND tipo = :tipo");
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
        $consulta->execute();

        $total_borrado = $consulta->rowCount();
        if ($total_borrado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    public function GuardarEnArchivo()
    {
        $path_actual = $this->pathFoto;
        $tipoArchivo = pathinfo($path_actual, PATHINFO_EXTENSION);
        $path_destino = "./recetasBorradas/" .
            $this->id . "." . $this->nombre . ".borrado." . date("G") . date("i") . date("s") .".". $tipoArchivo;

        if($path_actual != "") {
            copy($path_actual, $path_destino);
            $this->pathFoto = $path_destino;    
        }
        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/recetas_borradas.txt", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->ToJSON()},\r\n");
        if ($cant > 0) {
            if($path_actual != "") {
                unlink($path_actual);
            }
        }
        //CIERRO EL ARCHIVO
        fclose($ar);
    }
}


