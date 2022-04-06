<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 37</title>
</head>
<body>
    <form action="./curriculum.php" method="get">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <br><br>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <br><br>
        <input type="number" name="edad" placeholder="Edad" required>
        <br><br>
        <input type="text" name="direccion" placeholder="Direccion" required>
        <br><br>
        <input type="email" name="email" placeholder="Email" required>
        <br><br>
        <textarea name="cv" cols="30" rows="10" placeholder="Ingrese su curriculum aqui..."></textarea>
        <br><br>
        <input type="submit" value="Enviar CV">
    </form>
</body>
</html>