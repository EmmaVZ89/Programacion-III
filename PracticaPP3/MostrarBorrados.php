<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Receta.php");

use Zelarayan\AccesoDatos;
use Zelarayan\Receta;

$recetas = Receta::MostrarBorrados();

for ($i=0; $i < count($recetas); $i++) { 
    $receta = $recetas[$i];
    echo $receta->ToJSON() . "\n";    
}
