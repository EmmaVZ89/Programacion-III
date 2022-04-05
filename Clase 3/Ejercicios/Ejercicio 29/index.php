<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 29</title>
</head>

<body style="background-color: <?php if(count($_GET) != 0) echo  $_GET["color"]?>">

<!-- action es para que pagina quiero dirigir -->
<!-- Todos los input deben tener un name porque si no me los lee -->
<form action="./index.php" method="get">

<select name="color" id="">
    <option value="rgb(255, 0, 0)">Rojo</option>
    <option value="rgb(0, 255, 0)">Verde</option>
    <option value="rgb(0, 0, 255)">Azul</option>
    <option value="rgb(255, 255, 0)">Amarillo</option>
    <option value="rgb(127, 0, 255)">Violeta</option>
    <option value="rgb(255, 128, 0)">Naranja</option>
</select>

<input type="submit" value="Cambiar Color">

</form>
    
</body>
</html>