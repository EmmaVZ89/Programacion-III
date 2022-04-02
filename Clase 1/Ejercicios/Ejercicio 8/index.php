<?php
$num = 43;
$strNum = strval($num);
$nombre;
$decena;
$unidad;

if ($num === 20) {
    $nombre = "Veinte";
} else if ($num === 30) {
    $nombre = "Treinta";
} else if ($num === 40) {
    $nombre = "Cuarente";
} else if ($num === 50) {
    $nombre = "Cincuenta";
} else if ($num === 60) {
    $nombre = "Sesenta";
}

if ($strNum[1] !== "0") {
    if($strNum[0] === "2"){
        $decena = "Veinti";
    } else if($strNum[0] === "3"){
        $decena = "Treinta y ";
    } else if($strNum[0] === "4"){
        $decena = "Cuarenta y ";
    } else if($strNum[0] === "5"){
        $decena = "Cincuenta y ";
    } else if($strNum[0] === "6"){
        $decena = "Sesenta y ";
    }
    
    switch ($strNum[1]) {
        case "1":
            $unidad = "uno";
            break;
        case "2":
            $unidad = "dos";
            break;
        case "3":
            $unidad = "tres";
            break;
        case "4":
            $unidad = "cuatro";
            break;
        case "5":
            $unidad = "cinco";
            break;
        case "6":
            $unidad = "seis";
            break;
        case "7":
            $unidad = "siete";
            break;
        case "8":
            $unidad = "ocho";
            break;
        case "9":
            $unidad = "nueve";
            break;
    }
    $nombre = $decena . $unidad;
}

echo "Numero: " . $nombre;
