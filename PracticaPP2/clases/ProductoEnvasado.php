<?php

namespace Zelarayan;

require_once("./clases/IParte1.php");
require_once("./clases/IParte2.php");
require_once("./clases/IParte3.php");
require_once("./clases/Producto.php");

use PDO;
use stdClass;

class ProductoEnvasado extends Producto implements IParte1, IParte2, IParte3
{
    public int $id;
    public string $codigoBarra;
    public int $precio;
    public string $pathFoto;

    public function __construct(
        int $id = 0,
        string $codigoBarra = "",
        int $precio = 0,
        string $pathFoto = "",
        string $nombre = "",
        string $origen = ""
    ) {
        parent::__construct($nombre, $origen);
        $this->id = $id;
        $this->codigoBarra = $codigoBarra;
        $this->precio = $precio;
        $this->pathFoto = $pathFoto;
    }


    public function ToJSON(): string
    {
        $retorno = array(
            "nombre" => $this->nombre,
            "origen" => $this->origen,
            "id" => $this->id,
            "codigoBarra" => $this->codigoBarra,
            "precio" => $this->precio,
            "pathFoto" => $this->pathFoto
        );
        return json_encode($retorno);
    }

    public static function TraerProducto(int $id) {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM productos WHERE id = :id"
        );
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $productoEnv = null;
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $id = $fila["id"];
            $codigoBarra = $fila["codigoBarra"];
            $precio = $fila["precio"];
            $pathFoto = $fila["pathFoto"];
            $nombre = $fila["nombre"];
            $origen = $fila["origen"];
            $productoEnv = new ProductoEnvasado(
                $id,
                $codigoBarra,
                $precio,
                $pathFoto,
                $nombre,
                $origen
            );
        }

        return $productoEnv;
    }

    public static function MostrarBorrados(): array
    {
        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/productos_envasados_borrados.txt", "r");
        $contenido = "";
        //LEO LINEA X LINEA DEL ARCHIVO 
        while (!feof($ar)) {
            $contenido .= fgets($ar);
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        $array_productos = array();
        $array_contenido = explode(",\r\n", $contenido);
        for ($i = 0; $i < count($array_contenido); $i++) {
            if ($array_contenido[$i] != "") {
                $obj = json_decode($array_contenido[$i], true);
                $id = $obj["id"];
                $codigoBarra = $obj["codigoBarra"];
                $nombre = $obj["nombre"];
                $origen = $obj["origen"];
                $precio = $obj["precio"];
                $pathFoto = $obj["pathFoto"];
                $producto = new ProductoEnvasado($id,$codigoBarra,$precio,$pathFoto,$nombre,$origen);
                array_push($array_productos, $producto);
            }
        }

        return $array_productos;
    }

    public static function MostrarBorradosJSON() : array {
        $array_productos = array();

        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/productos_eliminados.json", "r");
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
                $producto =  json_decode($array_contenido[$i], true);
                $nombre = $producto["nombre"];
                $origen = $producto["origen"];
                $producto = new Producto($nombre, $origen);
                array_push($array_productos, $producto);
            }
        }

        return $array_productos;
    }

    public static function MostrarModificados() {
        
    }

    // IMPLEMENTACION DE INTERFACE IParte1
    public function Agregar(): bool
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "INSERT INTO productos (codigoBarra, nombre, origen, precio, pathFoto) "
                . "VALUES(:codigoBarra, :nombre, :origen, :precio, :pathFoto)"
        );

        $consulta->bindValue(":codigoBarra", $this->codigoBarra, PDO::PARAM_STR);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
        $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(":pathFoto", $this->pathFoto, PDO::PARAM_STR);

        $retorno = $consulta->execute();

        return $retorno;
    }

    public static function Traer(): array
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM productos"
        );
        $consulta->execute();

        $array_productos = array();
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $id = $fila["id"];
            $codigoBarra = $fila["codigoBarra"];
            $precio = $fila["precio"];
            $pathFoto = $fila["pathFoto"];
            $nombre = $fila["nombre"];
            $origen = $fila["origen"];
            $productoEnv = new ProductoEnvasado(
                $id,
                $codigoBarra,
                $precio,
                $pathFoto,
                $nombre,
                $origen
            );
            array_push($array_productos, $productoEnv);
        }

        return $array_productos;
    }

    // IMPLEMENTACION DE INTERFACE IParte2
    public static function Eliminar(int $id): bool
    {
        $retorno = false;
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta("DELETE FROM productos WHERE id = :id");
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $total_borrado = $consulta->rowCount();
        if ($total_borrado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    public function Modificar(): bool
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $cadena =
            "UPDATE productos SET codigoBarra = :codigoBarra, nombre = :nombre, origen = :origen, 
        precio = :precio, pathFoto = :pathFoto WHERE id = :id";
        $consulta = $accesoDatos->retornarConsulta($cadena);

        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":codigoBarra", $this->codigoBarra, PDO::PARAM_STR);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
        $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(":pathFoto", $this->pathFoto, PDO::PARAM_STR);
        $consulta->execute();

        $total_modificado = $consulta->rowCount();
        if ($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    // IMPLEMENTACION DE INTERFACE IParte3
    public function Existe(array $productos): bool
    {
        $retorno = false;

        for ($i = 0; $i < count($productos); $i++) {
            if (
                $productos[$i]->nombre == $this->nombre &&
                $productos[$i]->origen == $this->origen
            ) {
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    public function GuardarEnArchivo()
    {
        $path_actual = $this->pathFoto;
        $tipoArchivo = pathinfo($path_actual, PATHINFO_EXTENSION);
        $path_destino = "./productosBorrados/" .
            $this->id . "." . $this->nombre . ".borrado." . date("G") . date("i") . date("s") .".". $tipoArchivo;

        copy($path_actual, $path_destino);

        $this->pathFoto = $path_destino;

        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/productos_envasados_borrados.txt", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->ToJSON()},\r\n");
        if ($cant > 0) {
            unlink($path_actual);
        }
        //CIERRO EL ARCHIVO
        fclose($ar);
    }
}
