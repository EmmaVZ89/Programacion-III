<?php
require_once "./pasajero.php";
require_once "./vuelo.php";

$pasajero1 = new Pasajero("Emmanuel", "Zelarayan", 11111111, true);
$pasajero2 = new Pasajero("Soledad", "Quiroz", 22222222, true);
$pasajero3 = new Pasajero("Luna", "Rodriguez", 33333333, false);
$pasajero4 = new Pasajero("Miguel", "Gonzalez", 33333333, true);

$pasajero5 = new Pasajero("Micaela", "Salazar", 44444444, true);
$pasajero6 = new Pasajero("Natasha", "Perez", 55555555, false);
$pasajero7 = new Pasajero("Sol", "Bustamante", 66666666, true);
$pasajero8 = new Pasajero("Pedro", "Gomez", 7777777, true);

$vuelo1 = new Vuelo("Carpincho SA", 2000, 5);
$vuelo2 = new Vuelo("Manolo SRL", 1500, 3);


$vuelo1->agregarPasajero($pasajero1);
$vuelo1->agregarPasajero($pasajero2);
$vuelo1->agregarPasajero($pasajero3);
$vuelo1->agregarPasajero($pasajero4);

$vuelo2->agregarPasajero($pasajero5);
$vuelo2->agregarPasajero($pasajero6);
$vuelo2->agregarPasajero($pasajero7);
$vuelo2->agregarPasajero($pasajero8);

$vuelo1->mostrarVuelo();
$vuelo2->mostrarVuelo();

echo "Facturacion total: " . Vuelo::add($vuelo1, $vuelo2) . "<br><br>";

Vuelo::remove($vuelo2, $pasajero4);
Vuelo::remove($vuelo2, $pasajero8);
Vuelo::remove($vuelo2, $pasajero7);
Vuelo::remove($vuelo1, $pasajero2);

$vuelo1->mostrarVuelo();
$vuelo2->mostrarVuelo();


?>