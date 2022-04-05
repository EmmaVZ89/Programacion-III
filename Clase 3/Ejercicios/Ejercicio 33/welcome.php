<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
<?php 
    if(count($_GET) != 0){
        $pass1 = $_GET["pass1"];
        $pass2 = $_GET["pass2"];

        if($pass1 === $pass2){
            echo "<h3 style="."'color: green'".">Bienvenido</h3>";
        }
        else {
            echo "<h3 style="."'color: red'".">Contraseña incorrecta</h3>";
            echo "<a href="."'./index.php'".">Volver a la pagina principal</a>";
        }
    }
?>
</body>
</html>