<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Televisor.php");
use Zelarayan\Televisor;
use Zelarayan\AccesoDatos;

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : NULL;
$precio = isset($_POST["precio"]) ? (int) $_POST["precio"] : 0;
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : NULL;

if($tipo && $precio && $paisOrigen) {
    $televisor = new Televisor($tipo, $precio, $paisOrigen);
    $televisores = Televisor::Traer();
    if($televisor->Verificar($televisores)) {
        if($televisor->Agregar()){
            echo "Televisor agregado!";
        }
    } else {
        echo "El televisor ya existe en la base de datos";
    }
}

