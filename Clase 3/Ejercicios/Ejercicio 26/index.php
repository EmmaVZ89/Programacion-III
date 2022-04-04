<?php
    $nombre_archivo = 
    date("Y")."_".
    date("m")."_".
    date("d")."_".
    date("G")."_".
    date("i")."_".
    date("s");
    
	$path_origen = "./archivo.txt";
	$path_destino = "./misArchivos/" . $nombre_archivo . ".txt";
		
	$copio = copy($path_origen, $path_destino);
	
	if($copio)
	{
		echo "<h2> copia EXITOSA </h2><br/>";			
	}
	else
	{
		echo "<h2> no se pudo COPIAR </h2>";
	}

?>