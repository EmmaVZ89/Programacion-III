<?php

	//var_dump($_POST);
	
	$persona = json_decode($_POST["miPersona"], true);
	
	var_dump($persona);
	
	//echo $persona; //Error!
	
	//echo $persona->edad . " - " . $persona->nombre;	