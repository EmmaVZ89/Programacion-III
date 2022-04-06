<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 35</title>
</head>
<body>
    <form action="./index.php" method="get">
    <select name="destino">
        <option value="1">Rio de Janeiro</option>
        <option value="2">Punta del este</option>
        <option value="3">La Habana</option>
        <option value="4">Miami</option>
        <option value="5">Ibiza</option>
    </select>
    <br><br>
    <input type="submit" value="Ver Precio">
    </form>

    <?php
    if(count($_GET) != 0){
        $destino = $_GET["destino"];
        $valor;
        switch ($destino) {
            case '1':
                $valor = 900;
                break;
            case '2':
                $valor = 550;
                break;
            case '3':
                $valor = 1000;
                break;
            case '4':
                $valor = 1250;
                break;
            case '5':
                $valor = 1500;
                break;
        }
        echo "<h3 style='color:green'>Precio: US$ " . $valor . "</h3>"; 
    }
    ?>
</body>
</html>