namespace Entidad {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function Ver() {
    let path: string = (<HTMLInputElement>document.getElementById("txtPath"))
      .value;
    xhttp.open("POST", "./backend/back.php", true);

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
}

// C:/xampp/htdocs/Programacion-III/Laboratorio III/Ejercicios AJAX/Ejercicio 2/hola.txt
