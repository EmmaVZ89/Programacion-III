"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    function LeerArchivoJsonCiudades3() {
        let pagina = "./backend/administrarCiudades.php";
        xhttp.open("POST", pagina, true);
        // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        let form = new FormData();
        form.append("accion", "traerCiudades");
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    let ciudadesJson = JSON.parse(respuesta);
                    console.log(ciudadesJson);
                    const contenerdorTabla = (document.getElementById("contenedorTabla"));
                    contenerdorTabla.innerHTML = "";
                    const tabla = document.createElement("table");
                    const tbody = document.createElement("tbody");
                    const thead = document.createElement("thead");
                    const th = document.createElement("th");
                    let text = document.createTextNode("ACCION");
                    th.appendChild(text);
                    thead.appendChild(th);
                    for (const key in ciudadesJson[0]) {
                        if (key !== "coord") {
                            const th = document.createElement("th");
                            let text = document.createTextNode(key.toUpperCase());
                            th.appendChild(text);
                            thead.appendChild(th);
                        }
                        else {
                            for (const k in ciudadesJson[0][key]) {
                                const th = document.createElement("th");
                                let text = document.createTextNode(k.toUpperCase());
                                th.appendChild(text);
                                thead.appendChild(th);
                            }
                        }
                    }
                    ciudadesJson.forEach((ciudad) => {
                        const tr = document.createElement("tr");
                        const tdEliminar = document.createElement("td");
                        const a = document.createElement("a");
                        let text = document.createTextNode("Eliminar");
                        a.appendChild(text);
                        a.setAttribute("href", "#");
                        a.setAttribute("onclick", `Entidades.EliminarCiudad(${ciudad["_id"]})`);
                        tdEliminar.appendChild(a);
                        tr.appendChild(tdEliminar);
                        for (const key in ciudad) {
                            if (key !== "coord") {
                                const td = document.createElement("td");
                                let text = document.createTextNode(ciudad[key]);
                                td.appendChild(text);
                                tr.appendChild(td);
                            }
                            else {
                                for (const k in ciudad[key]) {
                                    const td = document.createElement("td");
                                    let text = document.createTextNode(ciudad[key][k]);
                                    td.appendChild(text);
                                    tr.appendChild(td);
                                }
                            }
                        }
                        tbody.appendChild(tr);
                    });
                    tabla.appendChild(thead);
                    tabla.appendChild(tbody);
                    contenerdorTabla.appendChild(tabla);
                }
            }
        };
    }
    Entidades.LeerArchivoJsonCiudades3 = LeerArchivoJsonCiudades3;
    function AgregarCiudad2() {
        let id = parseInt(document.getElementById("txtId").value);
        let nombre = (document.getElementById("txtNombre")).value;
        let pais = document.getElementById("txtPais")
            .value;
        let longitud = parseInt(document.getElementById("txtLongitud").value);
        let latitud = parseInt(document.getElementById("txtLatitud").value);
        let ciudad = {
            _id: id,
            name: nombre,
            country: pais,
            coord: { lon: longitud, lat: latitud },
        };
        let ciudadStr = JSON.stringify(ciudad);
        xhttp.open("POST", "./backend/administrarCiudades.php", true);
        let form = new FormData();
        form.append("accion", "agregarCiudad");
        form.append("ciudad", ciudadStr);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                console.log(xhttp.responseText);
                LeerArchivoJsonCiudades3();
            }
        };
    }
    Entidades.AgregarCiudad2 = AgregarCiudad2;
    function EliminarCiudad(id) {
        xhttp.open("POST", "./backend/administrarCiudades.php", true);
        let form = new FormData();
        form.append("accion", "quitarCiudad");
        form.append("id", id.toString());
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                console.log(xhttp.responseText);
                LeerArchivoJsonCiudades3();
            }
        };
    }
    Entidades.EliminarCiudad = EliminarCiudad;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map