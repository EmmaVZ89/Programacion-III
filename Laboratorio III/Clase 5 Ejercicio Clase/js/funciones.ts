namespace AJAX {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  // MostrarListado();

  export function CrearAlumno() {
    let legajo: string = (<HTMLInputElement>(
      document.getElementById("txtLegajo")
    )).value;
    let nombre: string = (<HTMLInputElement>(
      document.getElementById("txtNombre")
    )).value;
    let apellido: string = (<HTMLInputElement>(
      document.getElementById("txtApellido")
    )).value;
    let foto : any = (<HTMLInputElement> document.getElementById("foto"));

    xhttp.open("POST", "./BACKEND/nexo.php?accion=1", true);

    let form: FormData = new FormData();

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

  export function MostrarListado() {
    xhttp.open("GET", "./BACKEND/nexo.php?accion=2", true); // tomar como referencia el index.html
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let div = <HTMLDivElement>document.getElementById("div_listado");
        div.innerHTML = xhttp.responseText;
      }
    };
    xhttp.send();
  }

  export function MostrarListadoJson() {
    xhttp.open("GET", "./BACKEND/nexo.php?accion=10", true); // tomar como referencia el index.html
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let div = <HTMLDivElement>document.getElementById("div_listadoJson");
        div.innerHTML = xhttp.responseText;
      }
    };
    xhttp.send();
  }

  export function MostrarListadoBackend() {
    xhttp.open("GET", "./BACKEND/nexo.php?accion=8", true); // tomar como referencia el index.html
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let div = <HTMLDivElement>document.getElementById("div_listadoBack");
        div.innerHTML = xhttp.responseText;
      }
    };
    xhttp.send();
  }

  export function MostrarListadoFrontend() {
    xhttp.open("GET", "./BACKEND/nexo.php?accion=9", true); // tomar como referencia el index.html
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let div = <HTMLDivElement>document.getElementById("div_listadoFront");
        let respuesta: string = xhttp.responseText;
        let alumnosJson = JSON.parse(respuesta);

        const contenerdorTabla: HTMLDivElement = <HTMLDivElement>(
          document.getElementById("div_listadoFront")
        );
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
            if(key != "foto") {
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

  export function VerificarAlumno() {
    let legajo: string = (<HTMLInputElement>(
      document.getElementById("txtLegajoVer")
    )).value;

    xhttp.open("POST", "./BACKEND/nexo.php?accion=5", true);

    let form: FormData = new FormData();

    form.append("legajo", legajo);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        MostrarListado();
      }
    };
  }

  export function ModificarAlumno() {
    let legajo: string = (<HTMLInputElement>(
      document.getElementById("txtLegajoMod")
    )).value;
    let nombre: string = (<HTMLInputElement>(
      document.getElementById("txtNombreMod")
    )).value;
    let apellido: string = (<HTMLInputElement>(
      document.getElementById("txtApellidoMod")
    )).value;
    let foto : any = (<HTMLInputElement> document.getElementById("fotoMod"));

    xhttp.open("POST", "./BACKEND/nexo.php?accion=3", true);

    let form: FormData = new FormData();

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

  export function BorrarAlumno() {
    let legajo: string = (<HTMLInputElement>(
      document.getElementById("txtLegajoDel")
    )).value;

    xhttp.open("POST", "./BACKEND/nexo.php?accion=4", true);

    let form: FormData = new FormData();

    form.append("legajo", legajo);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        MostrarListado();
      }
    };
  }

}
