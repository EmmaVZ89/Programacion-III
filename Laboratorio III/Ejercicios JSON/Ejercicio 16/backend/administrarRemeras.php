<?php
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
$campo = isset($_POST["campo"]) ? $_POST["campo"] : NULL;
$caracteristica = isset($_POST["caracteristica"]) ? $_POST["caracteristica"] : NULL;

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

    case 'traerRemerasFiltradasPorCampo':
        $remeras_str = "";
        $archivo = fopen("./remeras.json", "r");
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $remeras_str .= $linea;
        }
        fclose($archivo);

        $remeras_array = array();
        $remeras_json = json_decode($remeras_str, true);

        for ($i = 0; $i < count($remeras_json); $i++) {
            switch ($campo) {
                case 'tamanio':
                    if (strtolower($remeras_json[$i]["size"]) == strtolower($caracteristica)) {
                        array_push($remeras_array, $remeras_json[$i]);
                    }
                    break;
                case 'color':
                    if (strtolower($remeras_json[$i]["color"]) == strtolower($caracteristica)) {
                        array_push($remeras_array, $remeras_json[$i]);
                    }
                    break;
                case 'pais':
                    if (strtolower($remeras_json[$i]["manofacturer"]["location"]["country"]) == strtolower($caracteristica)) {
                        array_push($remeras_array, $remeras_json[$i]);
                    }
                    break;
            }
        }

        $remeras_retorno = json_encode($remeras_array);

        echo $remeras_retorno;

        break;
}
