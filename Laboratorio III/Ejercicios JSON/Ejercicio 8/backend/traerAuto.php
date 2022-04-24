<?php

$auto = "";
$archivo = fopen("./auto.json", "r");
while (! feof($archivo)) {
    $auto .= fgets($archivo);
}
fclose($archivo);

echo $auto;
