<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum</title>
</head>
<body>
    <?php
    if(count($_GET) != 0){
        $nombre = $_GET["nombre"];
        $apellido = $_GET["apellido"];
        $edad = $_GET["edad"];
        $direccion = $_GET["direccion"];
        $email = $_GET["email"];
        $cv = $_GET["cv"];

        echo "<h3 style='color:red'>Nombre: " . $nombre . "</h3>"; 
        echo "<h3 style='color:red'>Apellido: " . $apellido . "</h3>"; 
        echo "<h3 style='color:red'>Edad: " . $edad . " años</h3>"; 
        echo "<h3 style='color:red'>Direccion: " . $direccion . "</h3>"; 
        echo "<h3 style='color:red'>Email: " . $email . "</h3>"; 
        echo "<h3 style='color:red'>CV Completo: " . $cv . "</h3><br>";
    }
    ?>
</body>
</html>