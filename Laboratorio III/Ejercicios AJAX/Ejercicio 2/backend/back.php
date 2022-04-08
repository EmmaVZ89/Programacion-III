<?php

$path = isset($_REQUEST["path"]) ? $_REQUEST["path"] : NULL;

function mostrar_contenido(string $path) : string {
    $retorno = "";
    if(file_exists($path)){
        $ar = fopen($path, "r");

        while(!feof($ar)){
        $retorno .= fgets($ar) . "<br>";		
        }

        fclose($ar);     
    }
    return $retorno;
}

echo mostrar_contenido($path);
