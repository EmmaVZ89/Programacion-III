<?php
$animales = array();
array_push($animales, "Perro");
array_push($animales, "Gato");
array_push($animales, "Raton");
array_push($animales, "Araña");
array_push($animales, "Mosca");

$anios = array();
array_push($anios, "1986");
array_push($anios, "1996");
array_push($anios, "2015");
array_push($anios, "78");
array_push($anios, "86");

$lenguajes = array();
array_push($lenguajes, "php");
array_push($lenguajes, "mysql");
array_push($lenguajes, "html5");
array_push($lenguajes, "typescript");
array_push($lenguajes, "ajax");

$arrayMerge = array_merge($animales, $anios, $lenguajes);

for ($i=0; $i < count($arrayMerge); $i++) { 
    echo $arrayMerge[$i] . "<br>";
}

?>