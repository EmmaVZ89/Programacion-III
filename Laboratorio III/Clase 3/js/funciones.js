"use strict";
var AJAX;
(function (AJAX) {
    let xhttp = new XMLHttpRequest();
    MostrarListado();
    function CrearAlumno() {
        let legajo = (document.getElementById("txtLegajo")).value;
        let nombre = (document.getElementById("txtNombre")).value;
        let apellido = (document.getElementById("txtApellido")).value;
        xhttp.open("POST", "./BACKEND/nexo.php?accion=1", true);
        let form = new FormData();
        form.append("legajo", legajo);
        form.append("nombre", nombre);
        form.append("apellido", apellido);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                alert(xhttp.responseText);
                MostrarListado();
            }
        };
    }
    AJAX.CrearAlumno = CrearAlumno;
    function MostrarListado() {
        xhttp.open("GET", "./BACKEND/nexo.php?accion=2", true); // tomar como referencia el index.html
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let div = document.getElementById("div_listado");
                div.innerHTML = xhttp.responseText;
            }
        };
        xhttp.send();
    }
    AJAX.MostrarListado = MostrarListado;
    function VerificarAlumno() {
        let legajo = (document.getElementById("txtLegajoVer")).value;
        xhttp.open("POST", "./BACKEND/nexo.php?accion=5", true);
        let form = new FormData();
        form.append("legajo", legajo);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                alert(xhttp.responseText);
                MostrarListado();
            }
        };
    }
    AJAX.VerificarAlumno = VerificarAlumno;
    function ModificarAlumno() {
        let legajo = (document.getElementById("txtLegajoMod")).value;
        let nombre = (document.getElementById("txtNombreMod")).value;
        let apellido = (document.getElementById("txtApellidoMod")).value;
        xhttp.open("POST", "./BACKEND/nexo.php?accion=3", true);
        let form = new FormData();
        form.append("legajo", legajo);
        form.append("nombre", nombre);
        form.append("apellido", apellido);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                alert(xhttp.responseText);
                MostrarListado();
            }
        };
    }
    AJAX.ModificarAlumno = ModificarAlumno;
    function BorrarAlumno() {
        let legajo = (document.getElementById("txtLegajoDel")).value;
        xhttp.open("POST", "./BACKEND/nexo.php?accion=4", true);
        let form = new FormData();
        form.append("legajo", legajo);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                alert(xhttp.responseText);
                MostrarListado();
            }
        };
    }
    AJAX.BorrarAlumno = BorrarAlumno;
})(AJAX || (AJAX = {}));
//# sourceMappingURL=funciones.js.map