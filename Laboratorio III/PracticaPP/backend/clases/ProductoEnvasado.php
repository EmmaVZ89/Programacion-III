<?php
namespace Zelarayan;

require_once("./clases/IParte1.php");
require_once("./clases/IParte2.php");
require_once("./clases/IParte3.php");
require_once("./clases/IParte4.php");
require_once("./clases/Producto.php");

use PDO;
use stdClass;

class ProductoEnvasado extends Producto implements IParte1, IParte2, IParte3, IParte4
{
    public int $id;
    public int $codigoBarra;
    public float $precio;
    public string $pathFoto;

    public function __construct(
        int $id = 0,
        int $codigoBarra = 0,
        float $precio = 0,
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


    public function toJSON(): string
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

    public static function TraerProducto(int $id)
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM productos WHERE id = :id"
        );
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $productoEnv = null;
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $id = $fila["id"];
            $codigoBarra = $fila["codigo_barra"];
            $precio = $fila["precio"];
            $pathFoto = $fila["foto"];
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
        $path = "./archivos/productos_envasados_borrados.txt";
        $array_productos = array();
        if (file_exists($path)) {
            //ABRO EL ARCHIVO
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
                    $codigoBarra = $obj["codigoBarra"];
                    $nombre = $obj["nombre"];
                    $origen = $obj["origen"];
                    $precio = $obj["precio"];
                    $pathFoto = $obj["pathFoto"];
                    $producto = new ProductoEnvasado($id, $codigoBarra, $precio, $pathFoto, $nombre, $origen);
                    array_push($array_productos, $producto);
                }
            }
        }

        return $array_productos;
    }

    public static function mostrarBorradosJSON(): array
    {
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

    // IMPLEMENTACION DE INTERFACE IParte1
    public function agregar(): bool
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $consulta = $accesoDatos->retornarConsulta(
            "INSERT INTO productos (codigo_barra, nombre, origen, precio, foto) "
                . "VALUES(:codigo_barra, :nombre, :origen, :precio, :foto)"
        );

        $consulta->bindValue(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
        $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);

        $retorno = $consulta->execute();

        return $retorno;
    }

    public static function traer(): array
    {
        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
        $consulta = $accesoDatos->retornarConsulta(
            "SELECT * FROM productos"
        );
        $consulta->execute();

        $array_productos = array();
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $id = $fila["id"];
            $codigoBarra = $fila["codigo_barra"];
            $precio = $fila["precio"];
            $pathFoto = $fila["foto"];
            $nombre = $fila["nombre"];
            $origen = $fila["origen"];
            if (!$pathFoto) {
                $pathFoto = "";
            }
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
    public static function eliminar(int $id): bool
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

    public function modificar(): bool
    {
        $retorno = false;

        $accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

        $cadena =
            "UPDATE productos SET codigo_barra = :codigo_barra, nombre = :nombre, origen = :origen, 
        precio = :precio, foto = :foto WHERE id = :id";
        $consulta = $accesoDatos->retornarConsulta($cadena);

        $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
        $consulta->bindValue(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
        $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
        $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);
        $consulta->execute();

        $total_modificado = $consulta->rowCount();
        if ($total_modificado == 1) {
            $retorno = true;
        }

        return $retorno;
    }

    // IMPLEMENTACION DE INTERFACE IParte3
    public function existe(array $productos): bool
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

    // IMPLEMENTACION DE INTERFACE IParte4
    public function guardarEnArchivo()
    {
        $path_actual = $this->pathFoto;
        $tipoArchivo = pathinfo($path_actual, PATHINFO_EXTENSION);
        $path_destino = "./productosBorrados/" .
            $this->id . "." . $this->nombre . ".borrado." . date("G") . date("i") . date("s") . "." . $tipoArchivo;

        if ($path_actual != "") {
            copy($path_actual, $path_destino);
            $this->pathFoto = $path_destino;
        }

        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/productos_envasados_borrados.txt", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->ToJSON()},\r\n");
        if ($cant > 0) {
            if ($path_actual != "") {
                unlink($path_actual);
            }
        }
        //CIERRO EL ARCHIVO
        fclose($ar);
    }
}
