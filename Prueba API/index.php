<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba API</title>
    <script src="./js/index.js" defer></script>
    <link href="./css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
    <form action="" method="get">
        <input type="text" name="algo">
        <input type="submit" value="GET">
    </form>
</body>
<div class="container text-center contenedor-cartas">
    <div class="row row-cols-5 mt-4 mb-4">
        <?php
        if (isset($_GET["algo"])) {
            $URL = "https://rickandmortyapi.com/api/character";
            $json = file_get_contents($URL);
            $datos = json_decode($json);
            $array_personajes = $datos->results;

            for ($i = 0; $i < count($array_personajes); $i++) {
                $img_personaje = "<img class='carta' src='{$array_personajes[$i]->image}' width='100px' alt='img'>";

                echo "<div id='{$array_personajes[$i]->id}' class='col'>";
                echo "<div class='card c-carta mt-2 mb-2'>";
                echo $img_personaje;
                echo "</div>";
                echo "</div>";
            }
            // echo dibujarTabla($array_personajes);
        }
        ?>
    </div>
</div>

</html>


<?php

function dibujarTabla(array $personajes): string
{
    $tabla = "";
    $tabla .= "<table>";
    $tabla .= "<thead>";
    foreach ($personajes[0] as $key => $value) {
        if ($key == "image" || $key == "name" || $key == "id") {
            $tabla .= "<th>" . $key . "</th>";
        }
    }
    $tabla .= "</thead";

    $tabla .= "<tboby>";
    for ($i = 0; $i < count($personajes); $i++) {
        $tabla .= "<tr>";
        foreach ($personajes[$i] as $key => $value) {
            if ($key == "image") {
                $tabla .= "<td><img src='" . $value . "' width='100px' alt='img'></td>";
            } else if ($key == "name" || $key == "id") {
                $tabla .= "<td>" . $value . "</td>";
            }
        }
        $tabla .= "</tr>";
    }
    $tabla .= "</tbody";
    $tabla .= "</table>";

    return $tabla;
}

?>