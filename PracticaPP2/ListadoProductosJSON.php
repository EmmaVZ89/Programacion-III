<?php
require_once("./clases/Producto.php");
use Zelarayan\Producto;


$productos = Producto::TraerJSON();

for ($i=0; $i < count($productos); $i++) { 
    $producto = $productos[$i];
    echo $producto->ToJSON() . "\n";    
}
