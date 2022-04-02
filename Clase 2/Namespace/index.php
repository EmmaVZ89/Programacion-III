<?php
require_once "./namespace.php";

use MiNamespace\ {
    Clase,
    //function funcion,
    const CONSTANTE
};

//solo uno
//use MiNamespace\Clase;

$obj_1 = new Clase();

echo Clase::test() . "<br/>";

$valor = CONSTANTE;

echo "<br/>" . $valor . "<br/>";

echo MiNamespace\funcion();

//echo funcion();

//con alias
use MiNamespace\Clase as UnaClase;

echo UnaClase::test();
