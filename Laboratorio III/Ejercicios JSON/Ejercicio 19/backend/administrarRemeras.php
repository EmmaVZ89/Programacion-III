<?php
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
$campo = isset($_POST["campo"]) ? $_POST["campo"] : NULL;
$caracteristica = isset($_POST["caracteristica"]) ? $_POST["caracteristica"] : NULL;
$remera = isset($_POST["remera"]) ? $_POST["remera"] : NULL;
$idRemera = isset($_POST["idRemera"]) ? $_POST["idRemera"] : NULL;

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

    case 'agregarRemera':
        $remeras_str = "";
        $archivo = fopen("./remeras.json", "r");
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $remeras_str .= $linea;
        }
        fclose($archivo);

        $remeras_json = json_decode($remeras_str, true);
        $remeraJSON = json_decode($remera);
        array_push($remeras_json, $remeraJSON);

        $remeras_str = json_encode($remeras_json);
        $archivo = fopen("./remeras.json", "w");
        //ESCRIBO EN EL ARCHIVO
        fwrite($archivo, $remeras_str);
        fclose($archivo);

        echo "Remera agregada!";

        break;

    case 'quitarRemera':
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
            if ($remeras_json[$i]["id"] == $idRemera) {
                continue;
            }
            array_push($remeras_array, $remeras_json[$i]);
        }

        $remeras_str = json_encode($remeras_array);
        $archivo = fopen("./remeras.json", "w");
        //ESCRIBO EN EL ARCHIVO
        fwrite($archivo, $remeras_str);
        fclose($archivo);

        echo "Remera Eliminada! ID: {$idRemera}";

        break;

    case 'obtenerRemera':
        $remeras_str = "";
        $archivo = fopen("./remeras.json", "r");
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $remeras_str .= $linea;
        }
        fclose($archivo);

        $remera_encontrada = "";
        $remeras_json = json_decode($remeras_str, true);
        for ($i = 0; $i < count($remeras_json); $i++) {
            if ($remeras_json[$i]["id"] == $idRemera) {
                $remera_encontrada = json_encode($remeras_json[$i]);
                break;
            }
        }

        echo $remera_encontrada;

        break;

    case 'modficarRemera':
        $remeras_str = "";
        $archivo = fopen("./remeras.json", "r");
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $remeras_str .= $linea;
        }
        fclose($archivo);

        $remeras_array = array();
        $remeraJson = json_decode($remera);
        $remeras_json = json_decode($remeras_str, true);
        for ($i = 0; $i < count($remeras_json); $i++) {
            if ($remeras_json[$i]["id"] == $idRemera) {
                array_push($remeras_array, $remeraJson);
                continue;
            }
            array_push($remeras_array, $remeras_json[$i]);
        }

        $remeras_str = json_encode($remeras_array);
        $archivo = fopen("./remeras.json", "w");
        //ESCRIBO EN EL ARCHIVO
        fwrite($archivo, $remeras_str);
        fclose($archivo);

        echo "Remera Modificada! ID: {$idRemera}";

        break;
}
