/// <reference path="./alumno.ts" />

const URL_API: string = "http://localhost:9876/";

namespace AJAX {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  // MostrarListado();

  export function CrearAlumno() {
    let legajo: string = (<HTMLInputElement>document.getElementById("txtLegajo")).value;
    let nombre: string = (<HTMLInputElement>document.getElementById("txtNombre")).value;
    let apellido: string = (<HTMLInputElement>document.getElementById("txtApellido")).value;
    let foto: any = <HTMLInputElement>document.getElementById("foto");
    let alumno = {
      legajo: legajo,
      nombre: nombre,
      apellido: apellido,
      foto: "",
    };

    xhttp.open("POST", URL_API + "alumnos", true);
    xhttp.setRequestHeader("enctype", "multipart/form-data");

    let form: FormData = new FormData();
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

  export async function MostrarListado(lista: number) {
    xhttp.open("GET", URL_API + "alumnos", true); // tomar como referencia el index.html
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let respuesta = xhttp.responseText;
        let alumnosArrayJson = JSON.parse(respuesta);

        switch (lista) {
          case 1:
            let div = <HTMLDivElement>document.getElementById("div_listado");
            let listado = "";
            alumnosArrayJson.forEach((alumno: AJAX.Alumno) => {
              listado += `${alumno.legajo} - ${alumno.apellido} - ${alumno.nombre} - ${alumno.foto}<br>`;
            });
            div.innerHTML = listado;
            break;

          case 2:
            let divJson = <HTMLDivElement>document.getElementById("div_listadoJson");
            divJson.innerText = respuesta;
            break;

          case 3:
            const contenerdorTabla: HTMLDivElement = <HTMLDivElement>(
              document.getElementById("div_listadoTabla")
            );

            contenerdorTabla.innerHTML = "";

            const tabla: HTMLTableElement = document.createElement("table");
            const tbody = document.createElement("tbody");

            const thead = document.createElement("thead");
            for (const key in alumnosArrayJson[0]) {
              const th = document.createElement("th");
              let text = document.createTextNode(key.toUpperCase());
              th.appendChild(text);
              thead.appendChild(th);
            }

            alumnosArrayJson.forEach((alumno: any) => {
              const tr = document.createElement("tr");
              for (const key in alumno) {
                if (key != "foto") {
                  const td = document.createElement("td");
                  let text = document.createTextNode(alumno[key]);
                  td.appendChild(text);
                  tr.appendChild(td);
                } else {
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
  }

  export function VerificarAlumno(): boolean {
    let retorno = false;
    let legajo: number = parseInt((<HTMLInputElement>document.getElementById("txtLegajoVer")).value);
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
        } else {
          console.log(`El alumno con legajo ${alumno.legajo} no esta en el listado.`);
        }
      }
    };
    return retorno;
  }

  export function ModificarAlumno() {
    let legajo: number = parseInt((<HTMLInputElement>document.getElementById("txtLegajoMod")).value);
    let nombre: string = (<HTMLInputElement>document.getElementById("txtNombreMod")).value;
    let apellido: string = (<HTMLInputElement>document.getElementById("txtApellidoMod")).value;
    let foto: any = <HTMLInputElement>document.getElementById("fotoMod");
    let alumno = {
      legajo: legajo,
      nombre: nombre,
      apellido: apellido,
      foto: "",
    };

    xhttp.open("POST", URL_API + "alumnos/modificar", true);
    xhttp.setRequestHeader("enctype", "multipart/form-data");

    let form: FormData = new FormData();
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
        } else {
          console.log(`El alumno con legajo ${legajo} no esta en el listado.`);
        }
      }
    };
  }

  export function BorrarAlumno() {
    let legajo: number = parseInt((<HTMLInputElement>document.getElementById("txtLegajoDel")).value);
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
  
}
