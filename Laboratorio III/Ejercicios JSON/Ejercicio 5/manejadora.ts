namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function RecibirJSON(): void {
    let pagina = "./BACKEND/recibirJson.php";

    xhttp.open("POST", pagina, true);
    xhttp.setRequestHeader(
      "content-type",
      "application/x-www-form-urlencoded"
    );
    xhttp.send(null);

    xhttp.onreadystatechange = () => {
      var DONE = 4;
      var OK = 200;
      if (xhttp.readyState === DONE) {
        if (xhttp.status === OK) {
          let respuesta: string = xhttp.responseText;
          let span: HTMLSpanElement = <HTMLSpanElement>(
            document.getElementById("respuesta")
          );
          let objJson = JSON.parse(xhttp.responseText);
          span.innerText = `Codigo: ${objJson.codigo} - Nombre: ${objJson.nombre} - Precio: ${objJson.precio}`;
          alert(objJson);
          console.log(objJson);
        }
      }
    };
  }
}
