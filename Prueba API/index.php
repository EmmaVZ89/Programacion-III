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
    <br><br><br>
    <?php
    if (isset($_GET["algo"])) {
        $URL = "https://rickandmortyapi.com/api/character";
        $json = file_get_contents($URL);
        $datos = json_decode($json);
        $array_personajes = $datos->results;
        shuffle($array_personajes);
        $array_10Personajes = array_slice($array_personajes, 0, 10);
        $array_10Personajes = array_merge($array_10Personajes, $array_10Personajes);
        

        $array_cartas = array();
        for ($i = 0; $i < count($array_10Personajes); $i++) {
            $id_personaje = $array_10Personajes[$i]->id;
            $img_personaje = "<img src='{$array_10Personajes[$i]->image}' alt='img'>";
            $nombre_personaje = $array_10Personajes[$i]->name;

            $carta = "";
            if($i >= 0 && $i <= 9 ) {
                $carta .= "<div class='tarjeta' >";
                $carta .= "<div class='face front' data-id='{$id_personaje}' name='cartaFrontA'>";
                $carta .= "<img src='./front.jpg' alt='img'>";
                $carta .= "</div>";
                $carta .= "<div class='face back'name='cartaBackA" . $id_personaje . "'>";
                $carta .= $img_personaje;
                $carta .= "<h3>" . $nombre_personaje . "</h3>";
                $carta .= "</div>";
                $carta .= "</div>";    
            } else {
                $carta .= "<div class='tarjeta' >";
                $carta .= "<div class='face front' data-id='{$id_personaje}' name='cartaFrontB'>";
                $carta .= "<img src='./front.jpg' alt='img'>";
                $carta .= "</div>";
                $carta .= "<div class='face back'name='cartaBackB" . $id_personaje . "'>";
                $carta .= $img_personaje;
                $carta .= "<h3>" . $nombre_personaje . "</h3>";
                $carta .= "</div>";
                $carta .= "</div>";    
            }
            array_push($array_cartas, $carta);
        }

        shuffle($array_cartas);
        for ($i=0; $i < count($array_cartas); $i++) { 
            echo $array_cartas[$i];
        }

    }
    ?>
</body>

</html>
