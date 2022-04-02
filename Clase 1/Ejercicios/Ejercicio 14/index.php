<?php

$arrayAsoc = array("animales" => array(), "anios" => array(), "lenguajes" => array());
array_push($arrayAsoc["animales"], "Perro");
array_push($arrayAsoc["animales"], "Gato");
array_push($arrayAsoc["animales"], "Raton");
array_push($arrayAsoc["animales"], "Araña");
array_push($arrayAsoc["animales"], "Mosca");
array_push($arrayAsoc["anios"], "1986");
array_push($arrayAsoc["anios"], "1996");
array_push($arrayAsoc["anios"], "2015");
array_push($arrayAsoc["anios"], "78");
array_push($arrayAsoc["anios"], "86");
array_push($arrayAsoc["lenguajes"], "php");
array_push($arrayAsoc["lenguajes"], "mysql");
array_push($arrayAsoc["lenguajes"], "html5");
array_push($arrayAsoc["lenguajes"], "typescript");
array_push($arrayAsoc["lenguajes"], "ajax");

$arrayIndex = array(array(), array(), array());
array_push($arrayIndex[0], "Perro");
array_push($arrayIndex[0], "Gato");
array_push($arrayIndex[0], "Raton");
array_push($arrayIndex[0], "Araña");
array_push($arrayIndex[0], "Mosca");
array_push($arrayIndex[1], "1986");
array_push($arrayIndex[1], "1996");
array_push($arrayIndex[1], "2015");
array_push($arrayIndex[1], "78");
array_push($arrayIndex[1], "86");
array_push($arrayIndex[2], "php");
array_push($arrayIndex[2], "mysql");
array_push($arrayIndex[2], "html5");
array_push($arrayIndex[2], "typescript");
array_push($arrayIndex[2], "ajax");

foreach ($arrayAsoc as $clave => $array) {
    echo "Clave: " . $clave . "<br>";
    foreach ($array as $indice => $value) {
        echo "Indice: " . $indice . " __ Valor: " . $value . "<br>";
    }
    echo "<br>";
}

echo "<br> Array Indexado  <br>";
for ($i=0; $i < count($arrayIndex) ; $i++) { 
    for ($j=0; $j < count($arrayIndex[$i]); $j++) { 
        echo $arrayIndex[$i][$j] . " ___ ";
    }
    echo "<br>";
}

?>