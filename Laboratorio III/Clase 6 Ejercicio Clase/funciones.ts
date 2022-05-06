namespace AJAX {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  window.addEventListener("load", () => {
    ListadoCRUD();
  });

  export function Agregar() {
    let legajo: string = (<HTMLInputElement>document.getElementById("legajo"))
      .value;
    let nombre: string = (<HTMLInputElement>document.getElementById("nombre"))
      .value;
    let apellido: string = (<HTMLInputElement>(
      document.getElementById("apellido")
    )).value;
    let foto: any = <HTMLInputElement>document.getElementById("foto");

    xhttp.open("POST", "./BACKEND/nexo.php?accion=1", true);

    let form: FormData = new FormData();

    form.append("legajo", legajo);
    form.append("nombre", nombre);
    form.append("apellido", apellido);
    form.append("foto", foto.files[0]);

    xhttp.setRequestHeader("enctype", "multipart/form-data");

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        // MostrarListado();
      }
    };
  }

  export function Listar() {
    xhttp.open("GET", "./BACKEND/nexo.php?accion=2", true);
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let div = <HTMLDivElement>document.getElementById("divListado");
        div.innerHTML = xhttp.responseText;
      }
    };
    xhttp.send();
  }

  export function Verificar() {
    let legajo: string = (<HTMLInputElement>document.getElementById("legajo_v"))
      .value;

    xhttp.open("POST", "./BACKEND/nexo.php?accion=5", true);

    let form: FormData = new FormData();

    form.append("legajo", legajo);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
      }
    };
  }

  export function Modificar() {
    let legajo: string = (<HTMLInputElement>document.getElementById("legajo_m"))
      .value;
    let nombre: string = (<HTMLInputElement>document.getElementById("nombre_m"))
      .value;
    let apellido: string = (<HTMLInputElement>(
      document.getElementById("apellido_m")
    )).value;
    let foto: any = <HTMLInputElement>document.getElementById("foto_m");

    xhttp.open("POST", "./BACKEND/nexo.php?accion=3", true);

    let form: FormData = new FormData();

    form.append("legajo", legajo);
    form.append("nombre", nombre);
    form.append("apellido", apellido);
    form.append("foto", foto.files[0]);

    xhttp.setRequestHeader("enctype", "multipart/form-data");

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        Listar();
      }
    };
  }

  export function Borrar() {
    let legajo: string = (<HTMLInputElement>document.getElementById("legajo_b"))
      .value;

    xhttp.open("POST", "./BACKEND/nexo.php?accion=4", true);

    let form: FormData = new FormData();

    form.append("legajo", legajo);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        Listar();
      }
    };
  }

  export function ListarObjetos() {
    xhttp.open("GET", "./BACKEND/nexo.php?accion=9", true);
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let div = <HTMLDivElement>document.getElementById("divListado_tabla");
        let respuesta: string = xhttp.responseText;
        let alumnosJson = JSON.parse(respuesta);

        const contenerdorTabla: HTMLDivElement = <HTMLDivElement>(
          document.getElementById("divListado_tabla")
        );

        contenerdorTabla.innerHTML = "";

        const tabla: HTMLTableElement = document.createElement("table");
        const tbody = document.createElement("tbody");

        const thead = document.createElement("thead");
        for (const key in alumnosJson[0]) {
          const th = document.createElement("th");
          let text = document.createTextNode(key.toUpperCase());
          th.appendChild(text);
          thead.appendChild(th);
        }

        alumnosJson.forEach((alumno: any) => {
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

  export function ListarTabla() {
    xhttp.open("GET", "./BACKEND/nexo.php?accion=8", true);
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let div = <HTMLDivElement>(
          document.getElementById("divListado_tabla_backend")
        );
        div.innerHTML = xhttp.responseText;
      }
    };
    xhttp.send();
  }

  export function ListadoCRUD() {
    xhttp.open("GET", "./BACKEND/nexo.php?accion=9", true);
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let respuesta: string = xhttp.responseText;
        let alumnosJson = JSON.parse(respuesta);

        const contenerdorTabla: HTMLDivElement = <HTMLDivElement>(
          document.getElementById("divListado_tabla_json")
        );

        contenerdorTabla.innerHTML = "";

        const tabla: HTMLTableElement = document.createElement("table");
        const tbody = document.createElement("tbody");

        const thead = document.createElement("thead");
        for (const key in alumnosJson[0]) {
          const th = document.createElement("th");
          let text = document.createTextNode(key.toUpperCase());
          th.appendChild(text);
          thead.appendChild(th);
        }
        const th = document.createElement("th");
        let text = document.createTextNode("ACCIONES");
        th.appendChild(text);
        thead.appendChild(th);

        alumnosJson.forEach((alumno: any) => {
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
              img.src = "./BACKEND" + alumno[key];
              img.width = 50;
              td.appendChild(img);
              tr.appendChild(td);
            }
          }
          const td = document.createElement("td");
          const buttonMod = document.createElement("button");
          const modText = document.createTextNode("Modificar");
          buttonMod.appendChild(modText);
          buttonMod.classList.add("btn", "btn-info");
          buttonMod.onclick = function ModificarAlumno() {
            (<HTMLInputElement>document.getElementById("legajo_m")).value =
              alumno.legajo;
            (<HTMLInputElement>document.getElementById("nombre_m")).value =
              alumno.nombre;
            (<HTMLInputElement>document.getElementById("apellido_m")).value =
              alumno.apellido;
            let foto: any = <HTMLImageElement>(
              document.getElementById("img_foto_m")
            );
            foto.src = "./BACKEND" + alumno.foto;
          };

          const buttonEli = document.createElement("button");
          const eliText = document.createTextNode("Eliminar");
          buttonEli.appendChild(eliText);
          buttonEli.classList.add("btn", "btn-danger");
          buttonEli.style.marginLeft = "10px";
          buttonEli.onclick = function EliminarAlumno() {
            let confirmacion = confirm(
              `Desea eliminar el alumno con legajo ${alumno.legajo} ?`
            );
            if (confirmacion) {
              xhttp.open("POST", "./BACKEND/nexo.php?accion=4", true);
              let form: FormData = new FormData();
              form.append("legajo", alumno.legajo.toString());
              xhttp.send(form);
              xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                  alert(xhttp.responseText);
                  Listar();
                }
              };
            }
          };

          td.appendChild(buttonMod);
          td.appendChild(buttonEli);
          tr.appendChild(td);
          tbody.appendChild(tr);
        });
        tabla.appendChild(thead);
        tabla.appendChild(tbody);
        contenerdorTabla.appendChild(tabla);
      }
    };
    xhttp.send();
  }

}
