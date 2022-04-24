<?php

	$persona = new stdClass();
	$persona->nombre = "Juan";
	$persona->edad = 66;

	$objJson = json_encode($persona);

	echo $objJson;
	
	//echo '{"nombre_persona" : ' . $persona->nombre . '}';