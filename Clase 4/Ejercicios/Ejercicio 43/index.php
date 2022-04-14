<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 43</title>
</head>

<body>
    <form action="./index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo">
        <br><br>
        <input type="submit" value="Subir Archivo">
        <br><br>
    </form>

    <?php
    if (isset($_FILES["archivo"])) {
        $nombre_archivo = $_FILES["archivo"]["name"];
        $size = $_FILES["archivo"]["size"];
        $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
        $nombre_archivo_sin_extension = pathinfo($nombre_archivo, PATHINFO_FILENAME);
        $path = "./uploads/" . $nombre_archivo;
        $max_size = 500000;
        $uploadOK = true;

        if ($extension == "doc" || $extension == "docx") {
            $max_size = 60000;
        } else if ($extension == "jpg" || $extension == "jpeg" || $extension == "gif") {
            $max_size = 300000;
            $esImagen = getimagesize($_FILES["archivo"]["tmp_name"]);
            if ($esImagen) {
                if ($extension != "jpg" && $extension != "jpeg" && $extension != "gif") {
                    echo "Solo son permitidas imagenes con extension JPG, JPEG o GIF.";
                    $uploadOk = false;
                }
            }
        }
        $size_kb = $size / 1000;
        $max_size_kb = $max_size/1000;

        if (file_exists($path)) {
            echo "El archivo {$nombre_archivo} ya existe!.";
            $uploadOK = false;
        }

        if ($size > $max_size) {
            echo "El archivo {$nombre_archivo} supera el peso permitido({$max_size_kb} kb).";
            $uploadOK = false;
        }

        if($uploadOK === false) {
            echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
        } else {
            if(move_uploaded_file($_FILES["archivo"]["tmp_name"], $path)) {
                echo "Archivo subido con exito!<br>";
                echo "Nombre: {$nombre_archivo_sin_extension}<br>";
                echo "Extension: {$extension}<br>";
                echo "Tamaño: {$size_kb} kb<br>";
            } else {
                echo "Ocurrio un error en la subida del archivo!";
            }
        }
    }
    ?>

</body>

</html>