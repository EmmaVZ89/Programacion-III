<?php

$email = isset($_GET["email"]) ? $_GET["email"] : NULL;


if($email) {
    $existe = false;
    $cookie = "";
    foreach ($_COOKIE as $key => $value) {
        if($key == $email) {
            $existe = true;
            $cookie = $key;
            break;
        }
    }

    if($existe) {
        echo "Cookie: " . $cookie;
    } else {
        echo "No se encuentra la cookie solicitada";
    }
}

// http://localhost/Programacion-III/PracticaPP/MostrarCookie.php?email=emma@emma.com
?>