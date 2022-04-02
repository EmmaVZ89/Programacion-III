<?php
$numeros = array(rand(0,10), rand(0,10), rand(0,10), rand(0,10), rand(0,10));
$resultado;

for ($i=0; $i < count($numeros) ; $i++) { 
    if($numeros[$i] < 6){
        $resultado = $numeros[$i] . " es menor a 6" . "<br>";
    } else if($numeros[$i] === 6){
        $resultado = $numeros[$i] . " es igual a 6" . "<br>";
    } else if($numeros[$i] > 6){
        $resultado = $numeros[$i] . " es mayor a 6" . "<br>";
    }
    echo $resultado;
}
