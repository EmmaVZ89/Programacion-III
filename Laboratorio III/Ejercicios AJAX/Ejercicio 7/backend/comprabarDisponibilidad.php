<?php
    
    $espera = rand(0, 3);
    sleep($espera);

    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : NULL;

    $nombres = "";
    $existe = false;
    if(file_exists("./nombres.txt")){
        $a = fopen("./nombres.txt","r");

        while(!feof($a)){
            $nombre = fgets($a);
            $nombre = trim($nombre);
            if($nombre == $usuario){
                $existe = true;
                fclose($a);
                break;
            }
        }

        if($existe){
            $a = fopen("nombresAlt.txt","r");
            while(!feof($a)){
                $nombre = fgets($a);
                $nombre = trim($nombre);
                if($nombre != $usuario){
                    if(strncmp($nombre, $usuario, strlen($usuario)) == 0){
                        $nombres .= "<li onclick='UsuarioAlternativo.CargarNombreAlternativo()'><a id='".$nombre."' href='#'>" . $nombre . "</a></li>";
                    }
                }
            }
            if($nombres == ""){
                echo "NO HAY ALTERNATIVAS";
            }
        }
        fclose($a);
    }

    echo $nombres;

?>