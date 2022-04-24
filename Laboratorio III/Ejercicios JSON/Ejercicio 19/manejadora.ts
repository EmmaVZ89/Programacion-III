namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function CargarRemeras6(): void {
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
          CrearTabla(remerasJson);
        }
      }
    };
  }

  export function FiltrarRemerasPorCampo4(): void {
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
          CrearTabla(remerasJson);
        }
      }
    };
  }

  export function AgregarRemera3(): void {
    let id: number = parseInt(
      (<HTMLInputElement>document.getElementById("txtId")).value
    );
    let slogan: string = (<HTMLInputElement>(
      document.getElementById("txtSlogan")
    )).value;
    let size: string = (<HTMLInputElement>document.getElementById("txtSize"))
      .value;
    let price: string = (<HTMLInputElement>document.getElementById("txtPrice"))
      .value;
    let color: string = (<HTMLInputElement>document.getElementById("txtColor"))
      .value;
    let name: string = (<HTMLInputElement>document.getElementById("txtName"))
      .value;
    let logo: string = (<HTMLInputElement>document.getElementById("txtLogo"))
      .value;
    let country: string = (<HTMLInputElement>document.getElementById("txtPais"))
      .value;
    let city: string = (<HTMLInputElement>document.getElementById("txtCiudad"))
      .value;
    let remera: any = {
      id: id,
      slogan: slogan,
      size: size,
      price: price,
      color: color,
      manofacturer: {
        name: name,
        logo: logo,
        location: {
          country: country,
          city: city,
        },
      },
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
        CargarRemeras6();
      }
    };
  }

  export function EliminarRemera2(idRemera: number): void {
    let respuesta: boolean = confirm(
      `¿ Desea eliminar articulo con ID "${idRemera}" ?`
    );
    if (respuesta) {
      xhttp.open("POST", "./backend/administrarRemeras.php", true);

      let form: FormData = new FormData();
      form.append("accion", "quitarRemera");
      form.append("idRemera", idRemera.toString());

      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta: string = xhttp.responseText;
          console.log(respuesta);
          CargarRemeras6();
        }
      };
    }
  }

  export function ObtenerRemeraYCargarCampos(idRemera: number): void {
    xhttp.open("POST", "./backend/administrarRemeras.php", true);

    let form: FormData = new FormData();
    form.append("accion", "obtenerRemera");
    form.append("idRemera", idRemera.toString());

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        let respuesta: string = xhttp.responseText;
        let remeraJson: any = JSON.parse(respuesta);
        (<HTMLInputElement>document.getElementById("txtId")).value =
          remeraJson.id;
        (<HTMLInputElement>document.getElementById("txtSlogan")).value =
          remeraJson.slogan;
        (<HTMLInputElement>document.getElementById("txtSize")).value =
          remeraJson.size;
        (<HTMLInputElement>document.getElementById("txtPrice")).value =
          remeraJson.price;
        (<HTMLInputElement>document.getElementById("txtColor")).value =
          remeraJson.color;
        (<HTMLInputElement>document.getElementById("txtName")).value =
          remeraJson.manofacturer.name;
        (<HTMLInputElement>document.getElementById("txtLogo")).value =
          remeraJson.manofacturer.logo;
        (<HTMLInputElement>document.getElementById("txtPais")).value =
          remeraJson.manofacturer.location.country;
        (<HTMLInputElement>document.getElementById("txtCiudad")).value =
          remeraJson.manofacturer.location.city;
        (<HTMLInputElement>document.getElementById("btnModificar")).disabled =
          false;
      }
    };
  }

  export function ModificarRemera(): void {
    let id: number = parseInt(
      (<HTMLInputElement>document.getElementById("txtId")).value
    );
    let slogan: string = (<HTMLInputElement>(
      document.getElementById("txtSlogan")
    )).value;
    let size: string = (<HTMLInputElement>document.getElementById("txtSize"))
      .value;
    let price: string = (<HTMLInputElement>document.getElementById("txtPrice"))
      .value;
    let color: string = (<HTMLInputElement>document.getElementById("txtColor"))
      .value;
    let name: string = (<HTMLInputElement>document.getElementById("txtName"))
      .value;
    let logo: string = (<HTMLInputElement>document.getElementById("txtLogo"))
      .value;
    let country: string = (<HTMLInputElement>document.getElementById("txtPais"))
      .value;
    let city: string = (<HTMLInputElement>document.getElementById("txtCiudad"))
      .value;
    let remera: any = {
      id: id,
      slogan: slogan,
      size: size,
      price: price,
      color: color,
      manofacturer: {
        name: name,
        logo: logo,
        location: {
          country: country,
          city: city,
        },
      },
    };

    let respuesta: boolean = confirm(
      `¿ Desea Modificar articulo con ID "${id}" ?`
    );
    if (respuesta) {
      let remeraStr = JSON.stringify(remera);

      xhttp.open("POST", "./backend/administrarRemeras.php", true);

      let form: FormData = new FormData();
      form.append("accion", "modficarRemera");
      form.append("idRemera", remera.id.toString());
      form.append("remera", remeraStr);

      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta: string = xhttp.responseText;
          console.log(respuesta);
          (<HTMLInputElement>document.getElementById("txtId")).value = "";
          (<HTMLInputElement>document.getElementById("txtSlogan")).value = "";
          (<HTMLInputElement>document.getElementById("txtSize")).value = "";
          (<HTMLInputElement>document.getElementById("txtPrice")).value = "";
          (<HTMLInputElement>document.getElementById("txtColor")).value = "";
          (<HTMLInputElement>document.getElementById("txtName")).value = "";
          (<HTMLInputElement>document.getElementById("txtLogo")).value = "";
          (<HTMLInputElement>document.getElementById("txtPais")).value = "";
          (<HTMLInputElement>document.getElementById("txtCiudad")).value = "";
          (<HTMLInputElement>document.getElementById("btnModificar")).disabled = true;
          CargarRemeras6();
        }
      };
    }
  }

  function CrearTabla(remerasJson: any) {
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
    const th = document.createElement("th");
    let text = document.createTextNode("ACCION");
    th.appendChild(text);
    thead.appendChild(th);

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
      const tdModificarElminar = document.createElement("td");
      const ae = document.createElement("a");
      const am = document.createElement("a");
      let textEli = document.createTextNode("Eliminar");
      let textMod = document.createTextNode("Modificar");
      let textEspacio = document.createTextNode(" / ");
      ae.appendChild(textEli);
      am.appendChild(textMod);
      ae.setAttribute("href", "#");
      am.setAttribute("href", "#");
      ae.setAttribute("onclick", `Entidades.EliminarRemera2(${remera["id"]})`);
      am.setAttribute(
        "onclick",
        `Entidades.ObtenerRemeraYCargarCampos(${remera["id"]})`
      );
      tdModificarElminar.appendChild(am);
      tdModificarElminar.appendChild(textEspacio);
      tdModificarElminar.appendChild(ae);
      tr.appendChild(tdModificarElminar);

      tbody.appendChild(tr);
    });

    tabla.appendChild(thead);
    tabla.appendChild(tbody);
    contenedorTabla.appendChild(tabla);
  }
}
