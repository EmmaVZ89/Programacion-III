namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function CargarRemeras4(): void {
    let pagina = "./backend/administrarRemeras.php";

    xhttp.open("POST", pagina, true);
    // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    let form: FormData = new FormData();
    form.append("accion", "traerRemeras");

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      var DONE = 4;
      var OK = 200;
      if (xhttp.readyState === DONE) {
        if (xhttp.status === OK) {
          let respuesta: string = xhttp.responseText;
          let remerasJson = JSON.parse(respuesta);

          const contenedorTabla = <HTMLDivElement>(
            document.getElementById("contenedorTabla")
          );
          contenedorTabla.innerHTML = "";
          const tabla = document.createElement("table");

          // Creacion del Thead
          const thead = document.createElement("thead");
          for (const key in remerasJson[0]) {
            if (key !== "manofacturer") {
              const th = document.createElement("th");
              const texto = document.createTextNode(key.toUpperCase());
              th.appendChild(texto);
              thead.appendChild(th);
            } else {
              for (const k in remerasJson[0]["manofacturer"]) {
                if (k !== "location") {
                  const th = document.createElement("th");
                  const texto = document.createTextNode(k.toUpperCase());
                  th.appendChild(texto);
                  thead.appendChild(th);
                } else {
                  for (const kk in remerasJson[0]["manofacturer"]["location"]) {
                    const th = document.createElement("th");
                    const texto = document.createTextNode(kk.toUpperCase());
                    th.appendChild(texto);
                    thead.appendChild(th);
                  }
                }
              }
            }
          }

          // Creacion del Tbody
          const tbody = document.createElement("tbody");
          remerasJson.forEach((remera: any) => {
            const tr = document.createElement("tr");
            for (const key in remera) {
              const td = document.createElement("td");
              if (key !== "manofacturer") {
                const texto = document.createTextNode(remera[key]);
                td.appendChild(texto);
                tr.appendChild(td);
              } else {
                for (const key in remera["manofacturer"]) {
                  if (key === "logo") {
                    const td = document.createElement("td");
                    const img = document.createElement("img");
                    const src = remera["manofacturer"]["logo"];
                    img.setAttribute("src", src);
                    img.setAttribute("alt", "img");
                    img.setAttribute("width", "50px");
                    td.appendChild(img);
                    tr.appendChild(td);
                  } else if (key === "location") {
                    for (const key in remera["manofacturer"]["location"]) {
                      const td = document.createElement("td");
                      const texto = document.createTextNode(
                        remera["manofacturer"]["location"][key]
                      );
                      td.appendChild(texto);
                      tr.appendChild(td);
                    }
                  } else {
                    const td = document.createElement("td");
                    const texto = document.createTextNode(
                      remera["manofacturer"][key]
                    );
                    td.appendChild(texto);
                    tr.appendChild(td);
                  }
                }
              }
            }
            tbody.appendChild(tr);
          });
          tabla.appendChild(thead);
          tabla.appendChild(tbody);
          contenedorTabla.appendChild(tabla);
        }
      }
    };
  }

  export function FiltrarRemerasPorCampo2(): void {
    let caracteristica = (<HTMLInputElement>(
      document.getElementById("txtCaracteristica")
    )).value;
    let campo = (<HTMLSelectElement>document.getElementById("txtCampo")).value;
    let pagina = "./backend/administrarRemeras.php";

    xhttp.open("POST", pagina, true);
    // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    let form: FormData = new FormData();
    form.append("accion", "traerRemerasFiltradasPorCampo");
    form.append("campo", campo);
    form.append("caracteristica", caracteristica);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      var DONE = 4;
      var OK = 200;
      if (xhttp.readyState === DONE) {
        if (xhttp.status === OK) {
          let respuesta: string = xhttp.responseText;
          let remerasJson = JSON.parse(respuesta);

          const contenedorTabla = <HTMLDivElement>(
            document.getElementById("contenedorTabla")
          );
          contenedorTabla.innerHTML = "";

          const tabla = document.createElement("table");

          // Creacion del Thead
          const thead = document.createElement("thead");
          for (const key in remerasJson[0]) {
            if (key !== "manofacturer") {
              const th = document.createElement("th");
              const texto = document.createTextNode(key.toUpperCase());
              th.appendChild(texto);
              thead.appendChild(th);
            } else {
              for (const k in remerasJson[0]["manofacturer"]) {
                if (k !== "location") {
                  const th = document.createElement("th");
                  const texto = document.createTextNode(k.toUpperCase());
                  th.appendChild(texto);
                  thead.appendChild(th);
                } else {
                  for (const kk in remerasJson[0]["manofacturer"]["location"]) {
                    const th = document.createElement("th");
                    const texto = document.createTextNode(kk.toUpperCase());
                    th.appendChild(texto);
                    thead.appendChild(th);
                  }
                }
              }
            }
          }

          // Creacion del Tbody
          const tbody = document.createElement("tbody");
          remerasJson.forEach((remera: any) => {
            const tr = document.createElement("tr");
            for (const key in remera) {
              const td = document.createElement("td");
              if (key !== "manofacturer") {
                const texto = document.createTextNode(remera[key]);
                td.appendChild(texto);
                tr.appendChild(td);
              } else {
                for (const key in remera["manofacturer"]) {
                  if (key === "logo") {
                    const td = document.createElement("td");
                    const img = document.createElement("img");
                    const src = remera["manofacturer"]["logo"];
                    img.setAttribute("src", src);
                    img.setAttribute("alt", "img");
                    img.setAttribute("width", "50px");
                    td.appendChild(img);
                    tr.appendChild(td);
                  } else if (key === "location") {
                    for (const key in remera["manofacturer"]["location"]) {
                      const td = document.createElement("td");
                      const texto = document.createTextNode(
                        remera["manofacturer"]["location"][key]
                      );
                      td.appendChild(texto);
                      tr.appendChild(td);
                    }
                  } else {
                    const td = document.createElement("td");
                    const texto = document.createTextNode(
                      remera["manofacturer"][key]
                    );
                    td.appendChild(texto);
                    tr.appendChild(td);
                  }
                }
              }
            }
            tbody.appendChild(tr);
          });
          tabla.appendChild(thead);
          tabla.appendChild(tbody);
          contenedorTabla.appendChild(tabla);
        }
      }
    };
  }

  export function AgregarRemera(): void {
    let id: number = parseInt((<HTMLInputElement>document.getElementById("txtId")).value);
    let slogan: string = (<HTMLInputElement>(document.getElementById("txtSlogan"))).value;
    let size: string = (<HTMLInputElement>document.getElementById("txtSize")).value;
    let price: string = (<HTMLInputElement>document.getElementById("txtPrice")).value;
    let color: string = (<HTMLInputElement>document.getElementById("txtColor")).value;
    let name: string = (<HTMLInputElement>document.getElementById("txtName")).value;
    let logo: string = (<HTMLInputElement>document.getElementById("txtLogo")).value;
    let country: string = (<HTMLInputElement>document.getElementById("txtPais")).value;
    let city: string = (<HTMLInputElement>document.getElementById("txtCiudad")).value;
    let remera: any = {
      "id": id,
      "slogan": slogan,
      "size": size,
      "price": price,
      "color": color,
      "manofacturer":
      {
        "name": name,
        "logo": logo,
        "location":
        {
          "country": country,
          "city": city
        }
      }
    };
    
    let remeraStr = JSON.stringify(remera);

    xhttp.open("POST", "./backend/administrarRemeras.php", true);

    let form: FormData = new FormData();
    form.append("accion", "agregarRemera");
    form.append("remera", remeraStr);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let respuesta: string = xhttp.responseText;
        console.log(respuesta);
        CargarRemeras4();
      }
    };
  }


}
