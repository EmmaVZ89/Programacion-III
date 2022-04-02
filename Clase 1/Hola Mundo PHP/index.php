<?php
// las variables se nombran con el signo $ en el inicio.
// se concatena con el operador "." punto.
// los operadores == y === se manejan como en JS.
// los booleanos los muetra como 1 (true) o como vacio (false)
$nombre = "Emmanuel";
$edad = 33;
$sueldo = 80300.88;

echo "hola mundo PHP!!!" . "<br>";
echo "Hola soy " . $nombre . ", tengo " . $edad . " años y mi sueldo es de $" . $sueldo . "<br>";

$var;
if (isset($var)) {
    echo $var;
} else {
    echo "La variable no esta definida" . "<br>";
}

$num = 10;
if($num == "10"){
    echo "Es un numero"  . "<br>";
}
if($num == 10){
    echo "Es un numero"  . "<br><br>";
}

// Array indexado
$vec = array(1,2,"3",true);
$vec[4] = 10;
array_push($vec, 88);
echo "MANERAS DE MOSTRAR UN ARRAY" . "<br>";
// echo $vec; // NO SE PUEDE MOSTRAR UN ARRAY CON ECHO.
var_dump($vec); // SE PUEDE MOSTRAR CON var_dump()

for ($i=0; $i < count($vec); $i++) { 
    echo $vec[$i] . "<br>";
}

foreach ($vec as $item) {
    echo $item . "<br>";
}
echo "<br>";

// Array asociativo

$vecAsoc = array("Juan" => 22, "Romina" => 12, "Uriel" => 8);
$vecAsoc["Emmanuel"] = 33;

var_dump($vecAsoc);

foreach ($vecAsoc as $item) {
    echo $item . "<br>";
}