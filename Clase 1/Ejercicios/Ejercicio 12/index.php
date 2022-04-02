<?php
$lapiceraUno = array();
$lapiceraUno["color"] = "negro";
$lapiceraUno["marca"] = "Bic";
$lapiceraUno["trazo"] = "Fino";
$lapiceraUno["precio"] = 120.50;

$lapiceraDos = array();
$lapiceraDos["color"] = "rojo";
$lapiceraDos["marca"] = "Patito";
$lapiceraDos["trazo"] = "Grueso";
$lapiceraDos["precio"] = 150.23;

$lapiceraTres = array();
$lapiceraTres["color"] = "azul";
$lapiceraTres["marca"] = "Castell";
$lapiceraTres["trazo"] = "Fino";
$lapiceraTres["precio"] = 170;

foreach ($lapiceraUno as $key => $value) {
    echo $key . ": " . $value . " _ ";
}
echo "<br><br>";
foreach ($lapiceraDos as $key => $value) {
    echo $key . ": " . $value . " _ ";
}
echo "<br><br>";
foreach ($lapiceraTres as $key => $value) {
    echo $key . ": " . $value . " _ ";
}
?>