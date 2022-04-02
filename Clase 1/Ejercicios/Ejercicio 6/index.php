<?php
$operador = "-";
$op1 = 5;
$op2 = 7;
$resultado;
$opInv = false;

switch ($operador) {
    case "+":
        $resultado = $op1 + $op2;
        break;
    case "-":
        $resultado = $op1 - $op2;
        break;
    case "*":
        $resultado = $op1 * $op2;
        break;
    case "/":
        $resultado = $op1 / $op2;
        break;

    default:
        echo "Operador invalido!!" . "<br>";
        $opInv = true;
        break;
}

if(! $opInv){
    echo "El resultado es: " . $resultado;
}
