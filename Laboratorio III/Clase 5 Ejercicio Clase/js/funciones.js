"use strict";
var AJAX;
(function (AJAX) {
    let xhttp = new XMLHttpRequest();
    // MostrarListado();
    function CrearAlumno() {
        let legajo = (document.getElementById("txtLegajo")).value;
        let nombre = (document.getElementById("txtNombre")).value;
        let apellido = (document.getElementById("txtApellido")).value;
        let foto = document.getElementById("foto");
        xhttp.open("POST", "./BACKEND/nexo.php?accion=1", true);
        let form = new FormData();
        form.append("legajo", legajo);
        form.append("nombre", nombre);
        form.append("apellido", apellido);
        form.append('foto', foto.files[0]);
        xhttp.setRequestHeader("enctype", "multipart/form-data");
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
    function MostrarListadoJson() {
        xhttp.open("GET", "./BACKEND/nexo.php?accion=10", true); // tomar como referencia el index.html
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let div = document.getElementById("div_listadoJson");
                div.innerHTML = xhttp.responseText;
            }
        };
        xhttp.send();
    }
    AJAX.MostrarListadoJson = MostrarListadoJson;
    function MostrarListadoBackend() {
        xhttp.open("GET", "./BACKEND/nexo.php?accion=8", true); // tomar como referencia el index.html
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let div = document.getElementById("div_listadoBack");
                div.innerHTML = xhttp.responseText;
            }
        };
        xhttp.send();
    }
    AJAX.MostrarListadoBackend = MostrarListadoBackend;
    function MostrarListadoFrontend() {
        xhttp.open("GET", "./BACKEND/nexo.php?accion=9", true); // tomar como referencia el index.html
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let div = document.getElementById("div_listadoFront");
                let respuesta = xhttp.responseText;
                let alumnosJson = JSON.parse(respuesta);
                const contenerdorTabla = (document.getElementById("div_listadoFront"));
                const tabla = document.createElement("table");
                const tbody = document.createElement("tbody");
                const thead = document.createElement("thead");
                for (const key in alumnosJson[0]) {
                    const th = document.createElement("th");
                    let text = document.createTextNode(key.toUpperCase());
                    th.appendChild(text);
                    thead.appendChild(th);
                }
                alumnosJson.forEach((alumno) => {
                    const tr = document.createElement("tr");
                    for (const key in alumno) {
                        if (key != "foto") {
                            const td = document.createElement("td");
                            let text = document.createTextNode(alumno[key]);
                            td.appendChild(text);
                            tr.appendChild(td);
                        }
                        else {
                            const td = document.createElement("td");
                            const img = document.createElement("img");
                            img.src = "./BACKEND" + alumno[key];
                            img.width = 50;
                            td.appendChild(img);
                            tr.appendChild(td);
                        }
                    }
                    tbody.appendChild(tr);
                });
                tabla.appendChild(thead);
                tabla.appendChild(tbody);
                contenerdorTabla.appendChild(tabla);
            }
        };
        xhttp.send();
    }
    AJAX.MostrarListadoFrontend = MostrarListadoFrontend;
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
        let foto = document.getElementById("fotoMod");
        xhttp.open("POST", "./BACKEND/nexo.php?accion=3", true);
        let form = new FormData();
        form.append("legajo", legajo);
        form.append("nombre", nombre);
        form.append("apellido", apellido);
        form.append('foto', foto.files[0]);
        xhttp.setRequestHeader("enctype", "multipart/form-data");
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