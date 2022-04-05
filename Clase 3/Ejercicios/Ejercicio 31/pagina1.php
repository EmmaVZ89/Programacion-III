<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina 1</title>
</head>
<body>
<?php
    $base = $_GET["base"];
    $altura = $_GET["altura"];
    $superficie = $base * $altura;
        
    echo "<br>Base: " . $base . " cm<br>" . 
    "Altura: " . $altura . " cm <br>" . 
    "Superficie: " . $superficie . " cm<br><br>";
?>
<a href="./index.php">Volver a pagina principal</a>
</body>
</html>
