namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function Ver() {
    let path: string = (<HTMLInputElement>document.getElementById("txtPath"))
      .value;
    xhttp.open("POST", "./backend/back.php?accion=1", true);

    let form: FormData = new FormData();
    form.append("path", path);
    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let div: HTMLDivElement = <HTMLDivElement>(
          document.getElementById("contenido")
        );

        let respuesta :string = xhttp.responseText;
        if(respuesta == "") {
            alert("El archivo no existe!!");
        } else {
            div.innerHTML = respuesta;
        }
        
      }
    };
  }

  export function VerificarPalabra() {
    let palabra: string = (<HTMLInputElement>document.getElementById("txtPalabra"))
      .value;
    xhttp.open("POST", "./backend/back.php?accion=2", true);

    let form: FormData = new FormData();
    form.append("path", "C:/xampp/htdocs/Programacion-III/Laboratorio III/Ejercicios AJAX/Ejercicio 2/hola.txt");
    form.append("palabra", palabra);
    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let respuesta :string = xhttp.responseText;
        alert(respuesta);
      }
    };
  }


  
}

// C:/xampp/htdocs/Programacion-III/Laboratorio III/Ejercicios AJAX/Ejercicio 2/hola.txt
