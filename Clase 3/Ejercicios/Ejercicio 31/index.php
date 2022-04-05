<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 31</title>
</head>
<body>
    <form action="./pagina1.php" method="get">
        <label for="">Base: </label>
        <input type="number" name="base" placeholder="Base">
        <br><br>
        <label for="">Altura: </label>
        <input type="number" name="altura" placeholder="Altura">
        <br><br>
        <input type="submit" value="Calcular Superficie">
    </form>
    <?php
    if(count($_GET) != 0){
        $base = $_GET["base"];
        $altura = $_GET["altura"];
        $superficie = $base * $altura;
        
        echo "<br>Base: " . $base . " cm<br>" . 
        "Altura: " . $altura . " cm <br>" . 
        "Superficie: " . $superficie . " cm<br>";
    }
    ?>

</body>
</html>