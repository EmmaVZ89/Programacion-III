<?php
require_once "./enigma.php";

$enigma = new Enigma();
$mensaje = "Hola mundo!!!";
$path = "./misArchivos/encriptado.txt";

if(Enigma::encriptar($mensaje, $path)){
    echo "Mensaje encriptado con exito!! <br>";
} else {
    echo "No se pudo encriptar el mensaje <br><br>";
}

echo "Mensaje desencriptado: " . Enigma::desencriptar($path) . "<br>";
?>