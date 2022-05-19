<?php
require_once("./clases/Producto.php");
use Zelarayan\Producto;

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : NULL;
$exito = false;
$mensaje = "El producto no existe";

if($nombre && $origen) {
    $producto = new Producto($nombre,$origen);
    $mensaje_json = json_decode(Producto::verificarProductoJSON($producto), true);
    if($mensaje_json["exito"]) {
        setcookie($nombre . "_" . $origen, date("YmdGis") . $mensaje_json["mensaje"], time()+3600, "/");
        $exito = true;
        $mensaje = "El producto se encuentra en el listado";
    }
}

$retornoJSON = array("exito" => $exito, "mensaje" => $mensaje .". ". $mensaje_json["mensaje"]);

echo json_encode($retornoJSON);