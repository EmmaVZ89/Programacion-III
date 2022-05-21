"use strict";
/// <reference path="./alumno.ts" />
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
const URL_API = "http://localhost:9876/";
var AJAX;
(function (AJAX) {
    let xhttp = new XMLHttpRequest();
    // MostrarListado();
    function CrearAlumno() {
        let legajo = document.getElementById("txtLegajo").value;
        let nombre = document.getElementById("txtNombre").value;
        let apellido = document.getElementById("txtApellido").value;
        let foto = document.getElementById("foto");
        let alumno = {
            legajo: legajo,
            nombre: nombre,
            apellido: apellido,
            foto: "",
        };
        xhttp.open("POST", URL_API + "alumnos", true);
        xhttp.setRequestHeader("enctype", "multipart/form-data");
        let form = new FormData();
        form.append("foto", foto.files[0]);
        form.append("alumno", JSON.stringify(alumno));
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let respuesta = xhttp.responseText;
                console.log(respuesta);
                MostrarListado(1);
                MostrarListado(2);
                MostrarListado(3);
            }
        };
    }
    AJAX.CrearAlumno = CrearAlumno;
    function MostrarListado(lista) {
        return __awaiter(this, void 0, void 0, function* () {
            xhttp.open("GET", URL_API + "alumnos", true); // tomar como referencia el index.html
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = xhttp.responseText;
                    let alumnosArrayJson = JSON.parse(respuesta);
                    switch (lista) {
                        case 1:
                            let div = document.getElementById("div_listado");
                            let listado = "";
                            alumnosArrayJson.forEach((alumno) => {
                                listado += `${alumno.legajo} - ${alumno.apellido} - ${alumno.nombre} - ${alumno.foto}<br>`;
                            });
                            div.innerHTML = listado;
                            break;
                        case 2:
                            let divJson = document.getElementById("div_listadoJson");
                            divJson.innerText = respuesta;
                            break;
                        case 3:
                            const contenerdorTabla = (document.getElementById("div_listadoTabla"));
                            contenerdorTabla.innerHTML = "";
                            const tabla = document.createElement("table");
                            const tbody = document.createElement("tbody");
                            const thead = document.createElement("thead");
                            for (const key in alumnosArrayJson[0]) {
                                const th = document.createElement("th");
                                let text = document.createTextNode(key.toUpperCase());
                                th.appendChild(text);
                                thead.appendChild(th);
                            }
                            alumnosArrayJson.forEach((alumno) => {
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
                                        img.src = URL_API + alumno[key];
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
                            break;
                        default:
                            break;
                    }
                }
            };
            xhttp.send();
        });
    }
    AJAX.MostrarListado = MostrarListado;
    function VerificarAlumno() {
        let retorno = false;
        let legajo = parseInt(document.getElementById("txtLegajoVer").value);
        let alumno = {
            legajo: legajo,
        };
        xhttp.open("POST", URL_API + "alumnos/verificar", true);
        xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF8");
        xhttp.send(JSON.stringify(alumno));
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let respuesta = xhttp.responseText;
                let alumnoJson = JSON.parse(respuesta);
                if (alumnoJson.legajo != undefined) {
                    console.log(alumnoJson);
                    retorno = true;
                }
                else {
                    console.log(`El alumno con legajo ${alumno.legajo} no esta en el listado.`);
                }
            }
        };
        return retorno;
    }
    AJAX.VerificarAlumno = VerificarAlumno;
    function ModificarAlumno() {
        let legajo = parseInt(document.getElementById("txtLegajoMod").value);
        let nombre = document.getElementById("txtNombreMod").value;
        let apellido = document.getElementById("txtApellidoMod").value;
        let foto = document.getElementById("fotoMod");
        let alumno = {
            legajo: legajo,
            nombre: nombre,
            apellido: apellido,
            foto: "",
        };
        xhttp.open("POST", URL_API + "alumnos/modificar", true);
        xhttp.setRequestHeader("enctype", "multipart/form-data");
        let form = new FormData();
        form.append("foto", foto.files[0]);
        form.append("alumno", JSON.stringify(alumno));
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let respuesta = xhttp.responseText;
                let alumnoJson = JSON.parse(respuesta);
                if (alumnoJson.legajo != undefined) {
                    console.log("Alumno Modificado!");
                    console.log(alumnoJson);
                    MostrarListado(1);
                    MostrarListado(2);
                    MostrarListado(3);
                }
                else {
                    console.log(`El alumno con legajo ${legajo} no esta en el listado.`);
                }
            }
        };
    }
    AJAX.ModificarAlumno = ModificarAlumno;
    function BorrarAlumno() {
        let legajo = parseInt(document.getElementById("txtLegajoDel").value);
        let alumno = {
            legajo: legajo,
        };
        xhttp.open("POST", URL_API + "alumnos/eliminar", true);
        xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF8");
        xhttp.send(JSON.stringify(alumno));
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let resultado = xhttp.responseText;
                console.log(resultado);
                MostrarListado(1);
                MostrarListado(2);
                MostrarListado(3);
            }
        };
    }
    AJAX.BorrarAlumno = BorrarAlumno;
})(AJAX || (AJAX = {}));
//# sourceMappingURL=funciones.js.map