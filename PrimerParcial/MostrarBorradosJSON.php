<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");

use Zelarayan\ProductoEnvasado;
use Zelarayan\AccesoDatos;


$productos = ProductoEnvasado::mostrarBorradosJSON();

for ($i=0; $i < count($productos); $i++) { 
    $producto = $productos[$i];
    echo $producto->ToJSON() . "\n";    
}
