"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    function CargarRemeras5() {
        let pagina = "./backend/administrarRemeras.php";
        xhttp.open("POST", pagina, true);
        // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        let form = new FormData();
        form.append("accion", "traerRemeras");
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    let remerasJson = JSON.parse(respuesta);
                    const contenedorTabla = (document.getElementById("contenedorTabla"));
                    contenedorTabla.innerHTML = "";
                    const tabla = document.createElement("table");
                    // Creacion del Thead
                    const thead = document.createElement("thead");
                    for (const key in remerasJson[0]) {
                        if (key !== "manofacturer") {
                            const th = document.createElement("th");
                            const texto = document.createTextNode(key.toUpperCase());
                            th.appendChild(texto);
                            thead.appendChild(th);
                        }
                        else {
                            for (const k in remerasJson[0]["manofacturer"]) {
                                if (k !== "location") {
                                    const th = document.createElement("th");
                                    const texto = document.createTextNode(k.toUpperCase());
                                    th.appendChild(texto);
                                    thead.appendChild(th);
                                }
                                else {
                                    for (const kk in remerasJson[0]["manofacturer"]["location"]) {
                                        const th = document.createElement("th");
                                        const texto = document.createTextNode(kk.toUpperCase());
                                        th.appendChild(texto);
                                        thead.appendChild(th);
                                    }
                                }
                            }
                        }
                    }
                    const th = document.createElement("th");
                    let text = document.createTextNode("ACCION");
                    th.appendChild(text);
                    thead.appendChild(th);
                    // Creacion del Tbody
                    const tbody = document.createElement("tbody");
                    remerasJson.forEach((remera) => {
                        const tr = document.createElement("tr");
                        for (const key in remera) {
                            const td = document.createElement("td");
                            if (key !== "manofacturer") {
                                const texto = document.createTextNode(remera[key]);
                                td.appendChild(texto);
                                tr.appendChild(td);
                            }
                            else {
                                for (const key in remera["manofacturer"]) {
                                    if (key === "logo") {
                                        const td = document.createElement("td");
                                        const img = document.createElement("img");
                                        const src = remera["manofacturer"]["logo"];
                                        img.setAttribute("src", src);
                                        img.setAttribute("alt", "img");
                                        img.setAttribute("width", "50px");
                                        td.appendChild(img);
                                        tr.appendChild(td);
                                    }
                                    else if (key === "location") {
                                        for (const key in remera["manofacturer"]["location"]) {
                                            const td = document.createElement("td");
                                            const texto = document.createTextNode(remera["manofacturer"]["location"][key]);
                                            td.appendChild(texto);
                                            tr.appendChild(td);
                                        }
                                    }
                                    else {
                                        const td = document.createElement("td");
                                        const texto = document.createTextNode(remera["manofacturer"][key]);
                                        td.appendChild(texto);
                                        tr.appendChild(td);
                                    }
                                }
                            }
                        }
                        const tdEliminar = document.createElement("td");
                        const a = document.createElement("a");
                        let text = document.createTextNode("Eliminar");
                        a.appendChild(text);
                        a.setAttribute("href", "#");
                        a.setAttribute("onclick", `Entidades.EliminarRemera(${remera["id"]})`);
                        tdEliminar.appendChild(a);
                        tr.appendChild(tdEliminar);
                        tbody.appendChild(tr);
                    });
                    tabla.appendChild(thead);
                    tabla.appendChild(tbody);
                    contenedorTabla.appendChild(tabla);
                }
            }
        };
    }
    Entidades.CargarRemeras5 = CargarRemeras5;
    function FiltrarRemerasPorCampo3() {
        let caracteristica = (document.getElementById("txtCaracteristica")).value;
        let campo = document.getElementById("txtCampo").value;
        let pagina = "./backend/administrarRemeras.php";
        xhttp.open("POST", pagina, true);
        // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        let form = new FormData();
        form.append("accion", "traerRemerasFiltradasPorCampo");
        form.append("campo", campo);
        form.append("caracteristica", caracteristica);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    let remerasJson = JSON.parse(respuesta);
                    const contenedorTabla = (document.getElementById("contenedorTabla"));
                    contenedorTabla.innerHTML = "";
                    const tabla = document.createElement("table");
                    // Creacion del Thead
                    const thead = document.createElement("thead");
                    for (const key in remerasJson[0]) {
                        if (key !== "manofacturer") {
                            const th = document.createElement("th");
                            const texto = document.createTextNode(key.toUpperCase());
                            th.appendChild(texto);
                            thead.appendChild(th);
                        }
                        else {
                            for (const k in remerasJson[0]["manofacturer"]) {
                                if (k !== "location") {
                                    const th = document.createElement("th");
                                    const texto = document.createTextNode(k.toUpperCase());
                                    th.appendChild(texto);
                                    thead.appendChild(th);
                                }
                                else {
                                    for (const kk in remerasJson[0]["manofacturer"]["location"]) {
                                        const th = document.createElement("th");
                                        const texto = document.createTextNode(kk.toUpperCase());
                                        th.appendChild(texto);
                                        thead.appendChild(th);
                                    }
                                }
                            }
                        }
                    }
                    // Creacion del Tbody
                    const tbody = document.createElement("tbody");
                    remerasJson.forEach((remera) => {
                        const tr = document.createElement("tr");
                        for (const key in remera) {
                            const td = document.createElement("td");
                            if (key !== "manofacturer") {
                                const texto = document.createTextNode(remera[key]);
                                td.appendChild(texto);
                                tr.appendChild(td);
                            }
                            else {
                                for (const key in remera["manofacturer"]) {
                                    if (key === "logo") {
                                        const td = document.createElement("td");
                                        const img = document.createElement("img");
                                        const src = remera["manofacturer"]["logo"];
                                        img.setAttribute("src", src);
                                        img.setAttribute("alt", "img");
                                        img.setAttribute("width", "50px");
                                        td.appendChild(img);
                                        tr.appendChild(td);
                                    }
                                    else if (key === "location") {
                                        for (const key in remera["manofacturer"]["location"]) {
                                            const td = document.createElement("td");
                                            const texto = document.createTextNode(remera["manofacturer"]["location"][key]);
                                            td.appendChild(texto);
                                            tr.appendChild(td);
                                        }
                                    }
                                    else {
                                        const td = document.createElement("td");
                                        const texto = document.createTextNode(remera["manofacturer"][key]);
                                        td.appendChild(texto);
                                        tr.appendChild(td);
                                    }
                                }
                            }
                        }
                        tbody.appendChild(tr);
                    });
                    tabla.appendChild(thead);
                    tabla.appendChild(tbody);
                    contenedorTabla.appendChild(tabla);
                }
            }
        };
    }
    Entidades.FiltrarRemerasPorCampo3 = FiltrarRemerasPorCampo3;
    function AgregarRemera2() {
        let id = parseInt(document.getElementById("txtId").value);
        let slogan = (document.getElementById("txtSlogan")).value;
        let size = document.getElementById("txtSize").value;
        let price = document.getElementById("txtPrice").value;
        let color = document.getElementById("txtColor").value;
        let name = document.getElementById("txtName").value;
        let logo = document.getElementById("txtLogo").value;
        let country = document.getElementById("txtPais").value;
        let city = document.getElementById("txtCiudad").value;
        let remera = {
            "id": id,
            "slogan": slogan,
            "size": size,
            "price": price,
            "color": color,
            "manofacturer": {
                "name": name,
                "logo": logo,
                "location": {
                    "country": country,
                    "city": city
                }
            }
        };
        let remeraStr = JSON.stringify(remera);
        xhttp.open("POST", "./backend/administrarRemeras.php", true);
        let form = new FormData();
        form.append("accion", "agregarRemera");
        form.append("remera", remeraStr);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let respuesta = xhttp.responseText;
                console.log(respuesta);
                CargarRemeras5();
            }
        };
    }
    Entidades.AgregarRemera2 = AgregarRemera2;
    function EliminarRemera(idRemera) {
        let respuesta = confirm(`¿ Desea eliminar articulo con ID "${idRemera}" ?`);
        if (respuesta) {
            xhttp.open("POST", "./backend/administrarRemeras.php", true);
            let form = new FormData();
            form.append("accion", "quitarRemera");
            form.append("idRemera", idRemera.toString());
            xhttp.send(form);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = xhttp.responseText;
                    console.log(respuesta);
                    CargarRemeras5();
                }
            };
        }
    }
    Entidades.EliminarRemera = EliminarRemera;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map