"use strict";
var Entidad;
(function (Entidad) {
    let xhttp = new XMLHttpRequest();
    function Ver() {
        let path = document.getElementById("txtPath")
            .value;
        xhttp.open("POST", "./backend/back.php", true);
        let form = new FormData();
        form.append("path", path);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let div = (document.getElementById("contenido"));
                let respuesta = xhttp.responseText;
                if (respuesta == "") {
                    alert("El archivo no existe!!");
                }
                else {
                    div.innerHTML = respuesta;
                }
            }
        };
    }
    Entidad.Ver = Ver;
})(Entidad || (Entidad = {}));
// C:/xampp/htdocs/Programacion-III/Laboratorio III/Ejercicios AJAX/Ejercicio 2/hola.txt
//# sourceMappingURL=entidad.js.map