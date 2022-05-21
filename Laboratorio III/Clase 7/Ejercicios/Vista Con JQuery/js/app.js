"use strict";
window.addEventListener("load", function () {
    Main.MostrarListado();
});
var Main;
(function (Main) {
    var URL_API = "http://localhost:9876/";
    var xhttp = new XMLHttpRequest();
    function MostrarListado() {
        xhttp.open("GET", URL_API + "alumnos", true);
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                var respuesta = xhttp.responseText;
                ArmarTablaConBotones(respuesta);
            }
        };
        xhttp.send();
    }
    Main.MostrarListado = MostrarListado;
    function ArmarTablaConBotones(data) {
        var array_alumnos = JSON.parse(data);
        console.log("Mostrar: ", array_alumnos);
        var div = $("#divListado");
        var tabla = "<table class=\"table table-hover\">\n                    <thead>\n                        <tr>\n                            <th>LEGAJO</th>\n                            <th>NOMBRE</th>\n                            <th>APELLIDO</th>\n                            <th>FOTO</th>\n                            <th>ACCIONES</th>\n                        </tr>\n                    </thead>\n                    <tbody>";
        if (array_alumnos.length < 1) {
            tabla += "<tr>\n                    <td>---</td>\n                    <td>---</td>\n                    <td>---</td>\n                    <td>---</td>\n                    <td>---</td>\n                </tr>";
        }
        else {
            for (var index = 0; index < array_alumnos.length; index++) {
                var dato = array_alumnos[index];
                tabla += "<tr>\n                    <td>".concat(dato.legajo, "</td>\n                    <td>").concat(dato.nombre, "</td>\n                    <td>").concat(dato.apellido, "</td>\n                    <td><img class=\"foto-tabla\" src=\"").concat(URL_API).concat(dato.foto, "\" width=\"80px\"></td>\n                    <td>\n                        <button type=\"button\" class=\"btn btn-info\" id=\"\" \n                        data-obj='").concat(JSON.stringify(dato), "' name=\"btnModificar\">\n                        <span class=\"bi bi-pencil\"></span>\n                        </button>\n                        <button type=\"button\" class=\"btn btn-danger\" id=\"\" \n                        data-legajo='").concat(dato.legajo, "' name=\"btnEliminar\">\n                        <span class=\"bi bi-x-circle\"></span>\n                        </button>\n                    </td>\n                </tr>");
            }
        }
        tabla += "</tbody></table>";
        div.html(tabla);
        document.getElementsByName("btnModificar").forEach(function (boton) {
            boton.addEventListener("click", function () {
                var obj = boton.getAttribute("data-obj");
                var obj_dato = JSON.parse(obj);
                $("#txtLegajo").val(obj_dato.legajo);
                $("#txtNombre").val(obj_dato.nombre);
                $("#txtApellido").val(obj_dato.apellido);
                $("#img_foto").attr("src", URL_API + obj_dato.foto);
                $("#div_foto").css("display", "block");
                $("#txtLegajo").attr("readOnly", "readOnly");
                var btn = $("#btnForm");
                btn.val("Modificar");
                btn.off("click", function () {
                    AgregarAlumno();
                });
                btn.on("click", function () {
                    ModificarAlumno();
                });
            });
        });
        document.getElementsByName("btnEliminar").forEach(function (boton) {
            boton.addEventListener("click", function () {
                var legajo = boton.getAttribute("data-legajo");
                if (confirm("\u00BFSeguro de eliminar el alumno con legajo ".concat(legajo, "?"))) {
                    var data_1 = "{\"legajo\": ".concat(legajo, "}");
                    EliminarAlumno(data_1);
                }
            });
        });
    }
    function AgregarAlumno() {
        var legajo = $("#txtLegajo").val();
        var nombre = $("#txtNombre").val();
        var apellido = $("#txtApellido").val();
        var foto = $("#foto").prop("files")[0];
        var alumno = {
            legajo: legajo,
            nombre: nombre,
            apellido: apellido,
            foto: "",
        };
        xhttp.open("POST", URL_API + "alumnos", true);
        xhttp.setRequestHeader("enctype", "multipart/form-data");
        var form = new FormData();
        form.append("foto", foto);
        form.append("alumno", JSON.stringify(alumno));
        xhttp.send(form);
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                var respuesta = xhttp.responseText;
                console.log("Agregar: ", respuesta);
                MostrarListado();
                LimpiarForm();
            }
        };
    }
    Main.AgregarAlumno = AgregarAlumno;
    function ModificarAlumno() {
        var legajo = $("#txtLegajo").val();
        var nombre = $("#txtNombre").val();
        var apellido = $("#txtApellido").val();
        var foto = $("#foto").prop("files")[0];
        var alumno = {
            legajo: legajo,
            nombre: nombre,
            apellido: apellido,
            foto: "",
        };
        xhttp.open("POST", URL_API + "alumnos/modificar", true);
        xhttp.setRequestHeader("enctype", "multipart/form-data");
        var form = new FormData();
        form.append("foto", foto);
        form.append("alumno", JSON.stringify(alumno));
        xhttp.send(form);
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                var respuesta = xhttp.responseText;
                var alumnoJson = JSON.parse(respuesta);
                console.log("Modificar: ", alumnoJson);
                var btn = $("#btnForm");
                btn.val("Guardar");
                btn.off("click", function () {
                    ModificarAlumno();
                });
                btn.on("click", function () {
                    AgregarAlumno();
                });
                MostrarListado();
                LimpiarForm();
            }
        };
    }
    Main.ModificarAlumno = ModificarAlumno;
    function EliminarAlumno(data) {
        xhttp.open("POST", URL_API + "alumnos/eliminar", true);
        xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF8");
        xhttp.send(data);
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                var respuesta = xhttp.responseText;
                console.log("Eliminar: ", respuesta);
                MostrarListado();
            }
        };
    }
    function LimpiarForm() {
        $("#txtLegajo").val("");
        $("#txtNombre").val("");
        $("#txtApellido").val("");
        $("#foto").val("");
        $("#img_foto").attr("src", "");
        $("#div_foto").css("display", "none");
        $("#txtLegajo").removeAttr("readOnly");
    }
})(Main || (Main = {}));
//# sourceMappingURL=app.js.map