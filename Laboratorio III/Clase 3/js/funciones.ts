namespace AJAX {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  MostrarListado();

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

    xhttp.open("POST", "./BACKEND/nexo.php?accion=1", true);

    let form: FormData = new FormData();

    form.append("legajo", legajo);
    form.append("nombre", nombre);
    form.append("apellido", apellido);

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

    xhttp.open("POST", "./BACKEND/nexo.php?accion=3", true);

    let form: FormData = new FormData();

    form.append("legajo", legajo);
    form.append("nombre", nombre);
    form.append("apellido", apellido);

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
