"use strict";
window.addEventListener("load", function () {
    Main.MostrarListado();
});
var Main;
(function (Main) {
    var URL_API = "http://localhost:9876/";
    var jqxhr = $.ajax();
    var btnForm = $("#btnForm");
    btnForm.on("click", AgregarAlumno);
    function MostrarListado() {
        $.ajax(URL_API + "alumnos")
            .done(function (respuesta) {
            ArmarTablaConBotones(respuesta);
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            console.error(jqXHR.responseText);
            console.error(textStatus + ": " + errorThrown);
        })
            .always(function () {
            console.log("***  Fin Mostrar  ***");
        });
    }
    Main.MostrarListado = MostrarListado;
    function ArmarTablaConBotones(data) {
        var array_alumnos = JSON.parse(data);
        console.log("Mostrar: ", array_alumnos);
        var div = $("#divListado");
        var tabla = ArmarTabla(array_alumnos);
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
                btnForm.val("Modificar");
                btnForm.off("click", AgregarAlumno);
                btnForm.on("click", ModificarAlumno);
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
    function ArmarTabla(array_alumnos) {
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
        return tabla;
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
        var pagina = URL_API + "alumnos";
        var form = new FormData();
        form.append("foto", foto);
        form.append("alumno", JSON.stringify(alumno));
        var obj_peticion = {
            type: "POST",
            url: pagina,
            dataType: "text",
            data: form,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            statusCode: {
                200: function () {
                    console.log("200 - Encontrado!!!");
                },
                404: function () {
                    console.log("404 - No encontrado!!!");
                },
            },
        };
        $.ajax(obj_peticion)
            .done(function (respuesta) {
            console.log("Agregar: ", respuesta);
            MostrarListado();
            LimpiarForm();
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            console.error(jqXHR.responseText);
            console.error(textStatus + ": " + errorThrown);
        })
            .always(function () {
            console.log("***  Fin Agregar  ***");
        });
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
        var pagina = URL_API + "alumnos/modificar";
        var form = new FormData();
        form.append("foto", foto);
        form.append("alumno", JSON.stringify(alumno));
        var obj_peticion = {
            type: "POST",
            url: pagina,
            dataType: "text",
            data: form,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
        };
        $.ajax(obj_peticion)
            .done(function (respuesta) {
            var alumnoJson = JSON.parse(respuesta);
            console.log("Modificar: ", alumnoJson);
            btnForm.val("Guardar");
            btnForm.off("click", ModificarAlumno);
            btnForm.on("click", AgregarAlumno);
            MostrarListado();
            LimpiarForm();
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            console.error(jqXHR.responseText);
            console.error(textStatus + ": " + errorThrown);
        })
            .always(function () {
            console.log("***  Fin Modificar  ***");
        });
    }
    Main.ModificarAlumno = ModificarAlumno;
    function EliminarAlumno(data) {
        var pagina = URL_API + "alumnos/eliminar";
        var obj_peticion = {
            type: "POST",
            url: pagina,
            dataType: "text",
            data: data,
            contentType: "application/json",
            async: true,
        };
        $.ajax(obj_peticion)
            .done(function (respuesta) {
            console.log("Eliminar: ", respuesta);
            MostrarListado();
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            console.error(jqXHR.responseText);
            console.error(textStatus + ": " + errorThrown);
        })
            .always(function () {
            console.log("***  Fin Eliminar  ***");
        });
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