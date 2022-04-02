<?php
require_once "./namespace.php";

$obj = new MiNamespace\Clase();

echo MiNamespace\Clase::test() . "<br/>";

echo MiNamespace\funcion();

$valor = MiNamespace\CONSTANTE;

echo "<br/>" . $valor;

echo "<br/>" . "namespace actual: " . __NAMESPACE__;


//ERROR
/*
$otroValor = CONSTANTE;

echo funcion();

$obj_1 = new clase();
*/