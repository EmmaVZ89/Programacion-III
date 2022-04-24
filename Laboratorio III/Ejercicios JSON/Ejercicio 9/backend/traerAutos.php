<?php

$autos = "";
$archivo = fopen("./autos.json", "r");
while (! feof($archivo)) {
    $autos .= fgets($archivo);
}
fclose($archivo);

echo $autos;
