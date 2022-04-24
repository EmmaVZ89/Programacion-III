<?php
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
$codigoPais = isset($_POST["codigoPais"]) ? $_POST["codigoPais"] : NULL;

switch ($accion) {
    case 'traerCiudades':
        $paises_str = "";
        $archivo = fopen("./paises.json", "r");
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $paises_str .= $linea;
        }
        fclose($archivo);

        $ciudades_array = array();
        $paises_json = json_decode($paises_str, true);
        for ($i=0; $i < count($paises_json); $i++) { 
            if($paises_json[$i]["CodigoPais"] == $codigoPais) {
                array_push($ciudades_array, $paises_json[$i]);
            }
        }

        $ciudades_json = json_encode($ciudades_array);

        echo $ciudades_json;

        break;
}
