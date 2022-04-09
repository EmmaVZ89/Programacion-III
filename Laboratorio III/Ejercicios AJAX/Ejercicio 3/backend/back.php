<?php

$accion = isset($_REQUEST["accion"]) ? (int) $_REQUEST["accion"] : 0;
$path = isset($_REQUEST["path"]) ? $_REQUEST["path"] : NULL;
$palabra = isset($_REQUEST["palabra"]) ? $_REQUEST["palabra"] : NULL;

switch ($accion) {
    case 1:
        echo mostrar_contenido($path);
        break;
    case 2:
        if(verificar_palabra($path, $palabra)){
            echo "La palabra '" . $palabra . "' se encuentra en el archivo!";
        } else {
            echo "La palabra '" . $palabra . "' NO se encuentra en el archivo!";
        }
        break;
    default:
        echo "Accion invalida!";
        break;
}

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

function verificar_palabra(string $path, string $palabra) : bool {
    $retorno = false;
    
    if(file_exists($path)){
        $ar = fopen($path, "r"); 
        while(!feof($ar))
        {
            $linea = fgets($ar);
            $array_linea = explode(" ", $linea);
            for ($i=0; $i < count($array_linea); $i++) { 
                $array_linea[$i] = trim($array_linea[$i]);
                if($array_linea[$i] != "" && $array_linea[$i] == $palabra){
                    $retorno = true;
                    break;
                }
            }
        }    
    }
    return $retorno;
}

