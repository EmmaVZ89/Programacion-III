<?php

namespace Zelarayan;
// require_once("./clases/IBM.php");
// use PDO;
use stdClass;

class Producto
{
    public string $nombre;
    public string $origen;

    public function __construct(
        string $nombre = "",
        string $origen = ""
    ) {
        $this->nombre = $nombre;
        $this->origen = $origen;
    }

    public function ToJSON(): string
    {
        $retorno = array("nombre" => $this->nombre, "origen" => $this->origen);
        return json_encode($retorno);
    }

    public function GuardarJSON(string $path): string
    {
        $exito = false;
        $mensaje = "No se pudo guardar el Producto";
        //ABRO EL ARCHIVO
        $ar = fopen($path, "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->ToJSON()},\r\n");
        if ($cant > 0) {
            $exito = true;
            $mensaje = "Producto Guardado con exito";
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        $retorno = array("exito" => $exito, "mensaje" => $mensaje);

        return json_encode($retorno);
    }

    public static function TraerJSON(): array
    {
        $array_productos = array();

        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/productos.json", "r");
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

    public static function VerificarProductoJSON(Producto $producto): string
    {
        $productos = Producto::TraerJSON();
        $array_nombres = array();
        $cantidadOrigen = 0;
        $flagMax = true;
        $max = 0;
        $exito = false;
        $mensaje = "";

        foreach ($productos as $prod) {
            array_push($array_nombres, $prod->nombre);

            if ($prod->nombre == $producto->nombre && $prod->origen == $producto->origen) {
                $exito = true;
            }

            if ($prod->origen == $producto->origen) {
                $cantidadOrigen++;
            }
        }

        $array_asoc_nombres = array_count_values($array_nombres);

        $cantidadProducto = 0;
        $productoMayor = "";

        foreach ($array_asoc_nombres as $key => $item) {
            $cantidadProducto = $item;

            if ($flagMax || $cantidadProducto > $max) {
                $max = $cantidadProducto;
                $productoMayor = $key;
                $flagMax = false;
            }
        }

        if ($exito) {
            $mensaje = "Hay un total de {$cantidadOrigen} productos con el mismo origen que el pasado por parametro";
        } else {
            $mensaje = "El producto con mas apariciones es {$productoMayor} con un total de {$max}";
        }

        $retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

        return json_encode($retornoJSON);
    }


}
