<?php
$suma = 0;
$i = 1;
$cant = 0;
while ($suma + $i <= 1000) {
    echo $i . "<br>";
    $suma += $i;
    $i++;
    $cant++;
}
echo "Suma: " . $suma . "<br>";
echo "Se sumaron " . $cant . " numeros";
?>