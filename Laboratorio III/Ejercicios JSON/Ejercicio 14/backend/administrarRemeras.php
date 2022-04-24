<?php
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;

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

}
