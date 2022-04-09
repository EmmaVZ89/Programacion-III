<?php
    $provincia = isset($_REQUEST["provincia"]) ? $_REQUEST["provincia"] : NULL;

    $array_provincias = 
    array(
        "Buenos Aires", "CABA", "Catamarca", "Chaco", "Chubut", "Cordoba", "Corrientes",
        "Entre Rios", "Formosa", "Jujuy", "La Pampa", "La Rioja", "Mendoza", "Misiones",
        "Neuquen", "Rio Negro", "Salta", "San Juan", "San Luis", "Santa Cruz", "Santa Fe",
        "Santiago del Estero", "Tierra del Fuego", "Tucuman"
    );

    $array_ciudades = 
    array(
        "Buenos Aires" => array("La Plata", "Bahia Blanca", "Merlo", "Quilmes"),
        "CABA" => array("Comuna 1", "Comuna 2", "Comuna 3"),
        "Catamarca" => array("San Fernando", "Tinogasta", "El Alto"),
        "Chaco" => array("Resistencia", "Saenz Peña"),
        "Chubut" => array("Rawson", "Puerto Madryn", "C. Rivadavia", "Trelew", "Esquel"),
        "Cordoba" => array("C. de Cordoba", "La Falda", "V. Carlos Paz"),
        "Corrientes" => array("C. de Corrientes", "Paso de los Libres", "Goya", "Bella Vista"),
        "Entre Rios" => array("Parana", "Colon", "Concordia", "Gualeguaychu"),
        "Formosa" => array("Formosa", "Ing Juarez", "Clorinda"),
        "Jujuy" => array("San Salvador de Jujuy", "San Pedro de Jujy", "Humahuaca"),
        "La Pampa" => array("Ciudad de Santa Rosa", "Eduardo Castex", "Gral Pico"),
        "La Rioja" => array("Chilecito", "Aimogasta", "Villa Sanagasta"),
        "Mendoza" => array("Guaymallen", "Las Heras", "Godoy Cruz", "San Rafael", "Maipu", "Lujan de Cuyo"),
        "Misiones" => array("Posadas", "El Dorado", "Obera", "Puerto Iguazu"),
        "Neuquen" => array("San Martir de los Andes", "Villa la Angostura", "Junin de los Andes"),
        "Rio Negro" => array("Viedma", "San Carlos de Bariloche", "Cipolletii", "El Bolson"),
        "Salta" => array("Tartagal", "Gral Guemes", "Embarcacion"),
        "San Juan" => array("San Juan", "Rawson", "Rivadavia", "Chimbas"),
        "San Luis" => array("C. de San Luis", "La Punta", "San Martin", "Concaran"),
        "Santa Cruz" => array("El Calafate", "Rio Gallegos", "Puerto Deseado", "Perito moreno"),
        "Santa Fe" => array("C. de Santa Fe", "Rosario", "Santo Tome", "San Lorenzo"),
        "Santiago del Estero" => array("La Banda", "Frias", "Termas de Rio Hondo"),
        "Tierra del Fuego" => array("Ushuaia", "Rio Grande", "Tolhuin", "Lago Escondido"),
        "Tucuman" => array("San Miguel de Tucuman", "Yerba Buena", "Tafi del Valle")
    );

    if(! $provincia){
        for ($i=0; $i < count($array_provincias) ; $i++) { 
            echo "<option value='" . $array_provincias[$i]. "'>" . $array_provincias[$i] . "</option>";
        }
    } else {
        $ciudades = $array_ciudades[$provincia];
        for ($i=0; $i < count($ciudades); $i++) { 
            echo "<option value='" . $ciudades[$i]. "'>" . $ciudades[$i] . "</option>";
        }
    }
?>