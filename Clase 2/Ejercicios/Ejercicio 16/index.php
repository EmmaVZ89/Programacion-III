<?php

$cadena = "HOLA";

echo "Cadena: " . $cadena . "<br>";
echo "Cadena invertida: " . invertirCadena("HOLA");

function invertirCadena($cadena){
    return strrev($cadena);
}