<?php

$num1 = 66;
$num2 = 33;

if(esPar($num1)){
    echo $num1 . " es par." . "<br>";
}

if(esImpar($num2)){
    echo $num2 . " es impar." . "<br>";
}

function esPar(int $numero):bool{
    if($numero % 2 === 0){
        return true;
    }
    return false;
}

function esImpar(int $numero):bool{
    return ! esPar($numero);
}
?>