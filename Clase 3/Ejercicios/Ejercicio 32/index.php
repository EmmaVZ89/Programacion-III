<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 32</title>
</head>
<body>
    <form action="./pagina1.php" method="get">
        <label for="">Base: </label>
        <input type="number" name="base" placeholder="Base">
        <br><br>
        <label for="">Altura: </label>
        <input type="number" name="altura" placeholder="Altura">
        <br><br>
        <input type="radio" name="calculo" value="1" checked> Superficie
        <input type="radio" name="calculo" value="2"> Perimetro
        <br><br>
        <input type="submit" value="Calcular">
    </form>
    <?php
    if(count($_GET) != 0){
        $base = $_GET["base"];
        $altura = $_GET["altura"];
        $calculo = $_GET["calculo"];

        echo "<br>Base: " . $base . " cm<br>" . 
        "Altura: " . $altura . " cm <br>";
        if($calculo == 1){
            $superficie = $base * $altura;
            echo "Superficie: " . $superficie . " cm<br>";
        } else {
            $perimetro = ($base * 2) + ($altura * 2);
            echo "Perimetro: " . $perimetro . " cm<br>";
        }
        
    }
    ?>

</body>
</html>