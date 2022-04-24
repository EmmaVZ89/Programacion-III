<?php
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
$agregarCiudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : NULL;
$idCiudad = isset($_POST["id"]) ? (int) $_POST["id"] : 0;

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

    case 'agregarCiudad':
        //ABRO EL ARCHIVO
        $ar = fopen("./city.list.min.json", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: legajo-nombre-apellido
        fwrite($ar, $agregarCiudad . "\r\n");
        //CIERRO EL ARCHIVO
        fclose($ar);

        echo $agregarCiudad;

        break;

    case 'quitarCiudad':
        $ciudades_array = array();
        //ABRO EL ARCHIVO
        $ar = fopen("./city.list.min.json", "r");
        //LEO LINEA X LINEA DEL ARCHIVO 
        while (!feof($ar)) {
            $linea = fgets($ar);
            if ($linea != "") {
                $ciudad = json_decode($linea, true);
                if ($ciudad["_id"] == $idCiudad) {
                    continue;
                }
                array_push($ciudades_array, $ciudad);
            }
        }
        fclose($ar);

        //ABRO EL ARCHIVO
        $ar = fopen("./city.list.min.json", "w");
        //ESCRIBO EN EL ARCHIVO
        foreach ($ciudades_array as $item) {
            fwrite($ar, json_encode($item) . "\r\n");
        }
        //CIERRO EL ARCHIVO
        fclose($ar);
        echo "Ciudad Eliminada";
        break;
}
