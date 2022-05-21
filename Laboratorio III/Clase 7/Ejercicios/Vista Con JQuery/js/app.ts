/// <reference path="ajax.ts" />
/// <reference path="../libs/jquery/index.d.ts" />

window.addEventListener("load", (): void => {
  Main.MostrarListado();
});

namespace Main {
  const URL_API: string = "http://localhost:9876/";
  const jqxhr = $.ajax();

  const btnForm = $("#btnForm");
  btnForm.on("click", AgregarAlumno);

  export function MostrarListado(): void {
    $.ajax(URL_API + "alumnos")
      .done((respuesta) => {
        ArmarTablaConBotones(respuesta);
      })
      .fail((jqXHR, textStatus, errorThrown) => {
        console.error(jqXHR.responseText);
        console.error(textStatus + ": " + errorThrown);
      })
      .always(() => {
        console.log("***  Fin Mostrar  ***");
      });
  }

  function ArmarTablaConBotones(data: string): void {
    let array_alumnos: any[] = JSON.parse(data);

    console.log("Mostrar: ", array_alumnos);

    let div = $("#divListado");
    let tabla = ArmarTabla(array_alumnos);

    div.html(tabla);

    document.getElementsByName("btnModificar").forEach((boton) => {
      boton.addEventListener("click", () => {
        let obj: any = boton.getAttribute("data-obj");
        let obj_dato = JSON.parse(obj);

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

    document.getElementsByName("btnEliminar").forEach((boton) => {
      boton.addEventListener("click", () => {
        let legajo: any = boton.getAttribute("data-legajo");

        if (confirm(`¿Seguro de eliminar el alumno con legajo ${legajo}?`)) {
          let data = `{"legajo": ${legajo}}`;
          EliminarAlumno(data);
        }
      });
    });
  }

  function ArmarTabla(array_alumnos: any): string {
    let tabla = `<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>LEGAJO</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>FOTO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>`;
    if (array_alumnos.length < 1) {
      tabla += `<tr>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                </tr>`;
    } else {
      for (let index = 0; index < array_alumnos.length; index++) {
        const dato = array_alumnos[index];
        tabla += `<tr>
                    <td>${dato.legajo}</td>
                    <td>${dato.nombre}</td>
                    <td>${dato.apellido}</td>
                    <td><img class="foto-tabla" src="${URL_API}${dato.foto}" width="80px"></td>
                    <td>
                        <button type="button" class="btn btn-info" id="" 
                        data-obj='${JSON.stringify(dato)}' name="btnModificar">
                        <span class="bi bi-pencil"></span>
                        </button>
                        <button type="button" class="btn btn-danger" id="" 
                        data-legajo='${dato.legajo}' name="btnEliminar">
                        <span class="bi bi-x-circle"></span>
                        </button>
                    </td>
                </tr>`;
      }
    }
    tabla += `</tbody></table>`;
    return tabla;
  }

  export function AgregarAlumno(): void {
    let legajo = $("#txtLegajo").val();
    let nombre = $("#txtNombre").val();
    let apellido = $("#txtApellido").val();
    let foto = $("#foto").prop("files")[0]; // accedo al obj del archivo
    let alumno = {
      legajo: legajo,
      nombre: nombre,
      apellido: apellido,
      foto: "",
    };

    let pagina = URL_API + "alumnos";

    let form: FormData = new FormData();
    form.append("foto", foto);
    form.append("alumno", JSON.stringify(alumno));

    let obj_peticion = {
      type: "POST",
      url: pagina,
      dataType: "text",
      data: form,
      async: true,
      cache: false,
      contentType: false,
      processData: false,
      statusCode: {
        200: () => {
          console.log("200 - Encontrado!!!");
        },
        404: () => {
          console.log("404 - No encontrado!!!");
        },
      },
    };

    $.ajax(obj_peticion) // salta como error pero funciona bien el codigo
      .done((respuesta) => {
        console.log("Agregar: ", respuesta);
        MostrarListado();
        LimpiarForm();
      })
      .fail((jqXHR, textStatus, errorThrown) => {
        console.error(jqXHR.responseText);
        console.error(textStatus + ": " + errorThrown);
      })
      .always(() => {
        console.log("***  Fin Agregar  ***");
      });
  }

  export function ModificarAlumno(): void {
    let legajo = $("#txtLegajo").val();
    let nombre = $("#txtNombre").val();
    let apellido = $("#txtApellido").val();
    let foto = $("#foto").prop("files")[0];
    let alumno = {
      legajo: legajo,
      nombre: nombre,
      apellido: apellido,
      foto: "",
    };

    let pagina = URL_API + "alumnos/modificar";

    let form: FormData = new FormData();
    form.append("foto", foto);
    form.append("alumno", JSON.stringify(alumno));

    let obj_peticion = {
      type: "POST",
      url: pagina,
      dataType: "text",
      data: form,
      async: true,
      cache: false,
      contentType: false,
      processData: false,
    };

    $.ajax(obj_peticion) // salta como error pero funciona bien el codigo
      .done((respuesta) => {
        let alumnoJson = JSON.parse(respuesta);
        console.log("Modificar: ", alumnoJson);

        btnForm.val("Guardar");
        btnForm.off("click", ModificarAlumno);
        btnForm.on("click", AgregarAlumno);

        MostrarListado();
        LimpiarForm();
      })
      .fail((jqXHR, textStatus, errorThrown) => {
        console.error(jqXHR.responseText);
        console.error(textStatus + ": " + errorThrown);
      })
      .always(() => {
        console.log("***  Fin Modificar  ***");
      });
  }

  function EliminarAlumno(data: string): void {
    let pagina = URL_API + "alumnos/eliminar";
    let obj_peticion = {
      type: "POST",
      url: pagina,
      dataType: "text",
      data: data,
      contentType: "application/json",
      async: true,
    };

    $.ajax(obj_peticion) // salta como error pero funciona bien el codigo
      .done((respuesta) => {
        console.log("Eliminar: ", respuesta);
        MostrarListado();
      })
      .fail((jqXHR, textStatus, errorThrown) => {
        console.error(jqXHR.responseText);
        console.error(textStatus + ": " + errorThrown);
      })
      .always(() => {
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
}

// FUNCIONES SOLO CON AJAX
// const xhttp: XMLHttpRequest = new XMLHttpRequest();
// MOSTRAR LISTADO
// xhttp.open("GET", URL_API + "alumnos", true); // tomar como referencia el index.html
// xhttp.onreadystatechange = () => {
//   if (xhttp.readyState == 4 && xhttp.status == 200) {
//     let respuesta = xhttp.responseText;
//     ArmarTablaConBotones(respuesta);
//   }
// };
// xhttp.send();

// AGREGARALUMNO
// xhttp.open("POST", URL_API + "alumnos", true);
// xhttp.setRequestHeader("enctype", "multipart/form-data");
// let form: FormData = new FormData();
// form.append("foto", foto);
// form.append("alumno", JSON.stringify(alumno));
// xhttp.send(form);
// xhttp.onreadystatechange = () => {
//   if (xhttp.readyState == 4 && xhttp.status == 200) {
//     let respuesta = xhttp.responseText;
//     console.log("Agregar: ", respuesta);
//     MostrarListado();
//     LimpiarForm();
//   }
// };

// MODIFICARALUMNO
// xhttp.open("POST", URL_API + "alumnos/modificar", true);
// xhttp.setRequestHeader("enctype", "multipart/form-data");
// let form: FormData = new FormData();
// form.append("foto", foto);
// form.append("alumno", JSON.stringify(alumno));
// xhttp.send(form);
// xhttp.onreadystatechange = () => {
//   if (xhttp.readyState == 4 && xhttp.status == 200) {
//     let respuesta = xhttp.responseText;
//     let alumnoJson = JSON.parse(respuesta);
//     console.log("Modificar: ", alumnoJson);
//     let btn = $("#btnForm");
//     btn.val("Guardar");
//     btn.off("click", (): void => {
//       ModificarAlumno();
//     });
//     btn.on("click", (): void => {
//       AgregarAlumno();
//     });
//     MostrarListado();
//     LimpiarForm();
//   }
// };

// ELIMINARALUMNO
// xhttp.open("POST", URL_API + "alumnos/eliminar", true);
// xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF8");
// xhttp.send(data);
// xhttp.onreadystatechange = () => {
//   if (xhttp.readyState == 4 && xhttp.status == 200) {
//     let respuesta = xhttp.responseText;
//     console.log("Eliminar: ", respuesta);
//     MostrarListado();
//   }
// };
