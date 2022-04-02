<?php
// include "nombre_archivo"; // produce un warning (el script continua)
// require "nombre_archivo"; // produce un fatal error (se detiene el script)

// include "./no_existe.php";
// require "./no_existe.php";

// include_once permite que un archivo solo se incluya una vez
// require_once

// include "../Funciones Propias/index.php";
require "./otroArchivo.php";

// SaludarDebil("Emma", "VZ");

echo "<br>" . "... continua el script ...";

?>