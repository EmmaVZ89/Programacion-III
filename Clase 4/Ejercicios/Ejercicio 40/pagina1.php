<?php
    session_start();

    $img = $_SESSION["img"];

    echo "<img src='".$img."'>";

    echo "<a href='./index.php'>Ir a pagina principal</a>";


    // session_destroy();
