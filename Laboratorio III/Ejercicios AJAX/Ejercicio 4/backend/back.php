<?php

    $op1 = isset($_REQUEST["op1"]) ? (int) $_REQUEST["op1"] : 0;
    $op2 = isset($_REQUEST["op2"]) ? (int) $_REQUEST["op2"] : 0;
    $operacion = isset($_REQUEST["operacion"]) ? $_REQUEST["operacion"] : "+";
    $resultado = 0;

    switch ($operacion) {
        case '+':
            $resultado = $op1 + $op2;
            break;
        case '-':
            $resultado = $op1 - $op2;
            break;
        case '*':
            $resultado = $op1 * $op2;
            break;
        case '/':
            if($op2 != 0){
                $resultado = $op1 / $op2;
            }
            break;
    }
    echo $resultado;
?>