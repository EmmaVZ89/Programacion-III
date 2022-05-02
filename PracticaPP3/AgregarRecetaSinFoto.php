<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Receta.php");
use Zelarayan\AccesoDatos;
use Zelarayan\Receta;

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$ingredientes = isset($_POST["ingredientes"]) ? $_POST["ingredientes"] : NULL;
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : NULL;
$exito = false;
$mensaje = "No se pudo agregar la receta";

if($nombre && $ingredientes && $tipo) {
    $receta = new Receta(0,$nombre,$ingredientes,$tipo);

    if($receta->Agregar()){
        $exito = true;
        $mensaje = "Receta agregada";
    }
}

$retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

echo json_encode($retornoJSON);
