<?php
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
$pais = isset($_POST["pais"]) ? $_POST["pais"] : NULL;

switch ($accion) {
    case 'traerRemeras':
        $remeras_str = "";
        $archivo = fopen("./remeras.json", "r");
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $remeras_str .= $linea;
        }
        fclose($archivo);

        echo $remeras_str;

        break;

    case 'traerRemerasFiltradas':
        $remeras_str = "";
        $archivo = fopen("./remeras.json", "r");
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $remeras_str .= $linea;
        }
        fclose($archivo);

        $remeras_array = array();
        $remeras_json = json_decode($remeras_str, true);
        for ($i=0; $i < count($remeras_json); $i++) { 
            if(strtolower($remeras_json[$i]["manofacturer"]["location"]["country"]) == strtolower($pais)) {
                array_push($remeras_array, $remeras_json[$i]);
            }
        }

        $remeras_retorno = json_encode($remeras_array);

        echo $remeras_retorno;
        
        break;
}
