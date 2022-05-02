<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");

use Zelarayan\ProductoEnvasado;
use Zelarayan\AccesoDatos;

$dir = opendir("./productosModificados");
// Leo todos los ficheros de la carpeta
echo "<table>";
while ($elemento = readdir($dir)) {
    // Tratamos los elementos . y .. que tienen todas las carpetas
    if ($elemento != "." && $elemento != "..") {
        // Muestro el fichero
        echo
        "<tr>
            <td>
                <img width='100px' src='./productosModificados/" . $elemento . "'>
            </td>
        </tr>";
    }
}
echo "</table>";
