<?php

//RECUPERO TODOS LOS VALORES (POST)
$numero = isset($_REQUEST["numero"]) ? (int) $_REQUEST["numero"] : 0;
$numero = (int) $numero;
$contador = 0;

if($numero > 0){
    for ($i=0; $i < $numero; $i++) { 
        if($i % 2 != 0){
            $contador++;
        }
    }    
}

echo $contador;