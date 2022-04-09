namespace UsuarioAlternativo {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function Verificar(): void {
    let usuario: string = (<HTMLInputElement>(
      document.getElementById("txtUsuario")
    )).value;

    AdministrarGif(true);

    xhttp.open("POST", "./backend/comprabarDisponibilidad.php", true);

    let form: FormData = new FormData();
    form.append("usuario", usuario);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      var DONE = 4;
      var OK = 200;
      if (xhttp.readyState === DONE) {
        if (xhttp.status === OK) {
          let respuesta: string = xhttp.responseText;

          if (respuesta == "") {
            alert(
              `El nombre de usuario '${usuario}' ${respuesta} esta disponible.`
            );
          } else {
            alert(`El nombre de usuario '${usuario}' NO esta disponible.`);
            let ul: HTMLUListElement = <HTMLUListElement>(
              document.getElementById("nombresAlternativos")
            );
            ul.innerHTML = respuesta;
          }
          AdministrarGif(false);
        } else {
          AdministrarGif(false);
        }
      }
    };
  }

  export function CargarNombreAlternativo() {
    let ul: HTMLUListElement = <HTMLUListElement>(
      document.getElementById("nombresAlternativos")
    );

    ul.addEventListener("click", manejador);
  }

  function manejador(evento: Event) {
    if (evento.target instanceof HTMLAnchorElement) {
      let id = evento.target.id;
      let nombre: HTMLInputElement = <HTMLInputElement>(
        document.getElementById("txtUsuario")
      );
      nombre.value = id;
    }
  }

  function AdministrarGif(mostrar: boolean): void {
    var gif: string = "./assets/load.gif";
    let div = <HTMLDivElement>document.getElementById("divGif");
    let img = <HTMLImageElement>document.getElementById("imgGif");

    if (mostrar) {
      div.style.display = "block";
      div.style.top = "50%";
      div.style.left = "45%";
      img.src = gif;
    }

    if (!mostrar) {
      div.style.display = "none";
      img.src = "";
    }
  }
}
