"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    function LeerArchivoJsonAutos() {
        let pagina = "./backend/traerAutos.php";
        xhttp.open("POST", pagina, true);
        xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        xhttp.send(null);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    let autosJson = JSON.parse(respuesta);
                    const contenerdorTabla = (document.getElementById("contenedorTabla"));
                    const tabla = document.createElement("table");
                    const tbody = document.createElement("tbody");
                    const thead = document.createElement("thead");
                    for (const key in autosJson[0]) {
                        const th = document.createElement("th");
                        let text = document.createTextNode(key.toUpperCase());
                        th.appendChild(text);
                        thead.appendChild(th);
                    }
                    autosJson.forEach((auto) => {
                        const tr = document.createElement("tr");
                        for (const key in auto) {
                            const td = document.createElement("td");
                            let text = document.createTextNode(auto[key]);
                            td.appendChild(text);
                            tr.appendChild(td);
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
    Entidades.LeerArchivoJsonAutos = LeerArchivoJsonAutos;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map