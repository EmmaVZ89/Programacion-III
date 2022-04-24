<?php

$accion = $_POST["traerCiudades"];

switch ($accion) {
    case 'traerCiudades':
        $ciudades_array = array();
        $archivo = fopen("./city.list.min.json", "r");
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            if ($linea != "") {
                $ciudad = json_decode($linea);
                array_push($ciudades_array, $ciudad);
            }
        }
        fclose($archivo);

        $ciudades_str = json_encode($ciudades_array);

        echo $ciudades_str;

        break;
}
