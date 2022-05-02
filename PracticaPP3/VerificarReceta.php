<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Receta.php");
use Zelarayan\AccesoDatos;
use Zelarayan\Receta;

$receta_json = isset($_POST["receta"]) ? $_POST["receta"] : NULL;
$mensaje = "";

if($receta_json) {
    $obj = json_decode($receta_json, true);
    $recetas = Receta::Traer();
    $receta = new Receta(0, $obj["nombre"], "", $obj["tipo"]);
    
    if($receta->Existe($recetas)) {
        for ($i = 0; $i < count($recetas); $i++) {
            if (
                $recetas[$i]->nombre == $receta->nombre &&
                $recetas[$i]->tipo == $receta->tipo
            ) {
                $receta = $recetas[$i];
                break;
            }
        }
        echo $receta->ToJSON();
    } else {
        for ($i = 0; $i < count($recetas); $i++) {
            if ($recetas[$i]->nombre == $receta->nombre) {
                $mensaje = "El tipo es diferente";
            } else if ($recetas[$i]->tipo == $receta->tipo) {
                $mensaje = "El nombre es diferente";
            } else if ($recetas[$i]->nombre != $receta->nombre &&
                        $recetas[$i]->tipo != $receta->tipo) {
                $mensaje = "El nombre y el tipo son diferentes";
            }
        }
        echo $mensaje;
    }

}