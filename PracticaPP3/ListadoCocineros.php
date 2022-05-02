<?php
require_once("./clases/Cocinero.php");
use Zelarayan\Cocinero;


$cocineros = Cocinero::TraerTodos();

for ($i=0; $i < count($cocineros); $i++) { 
    $cocinero = $cocineros[$i];
    echo $cocinero->ToJSON() . "\n";    
}
