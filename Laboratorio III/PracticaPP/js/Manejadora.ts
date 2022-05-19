/// <reference path="./Producto.ts" />
/// <reference path="./ProductoEnvasado.ts" />
/// <reference path="./Iparte2.ts" />
/// <reference path="./Iparte3.ts" />
/// <reference path="./Iparte4.ts" />

let xhttp: XMLHttpRequest = new XMLHttpRequest();

// let producto = new Entidades.Producto("agua mineral", "manantial");
// console.log(producto);
// console.log(producto.ToString());
// console.log(producto.ToJSON());
// console.log(producto["nombre"]);

// let productoEnvasado = new Entidades.ProductoEnvasado("aguamneral", "manantial", 2, "esfr123", 330);
// console.log(productoEnvasado["origen"]);
// // console.log("##########");
// console.log(productoEnvasado);
// console.log(productoEnvasado.ToJSON());

namespace PrimerParcial {
  export class Manejadora implements Iparte2, Iparte3, Iparte4 {
    // FUNCIONES PRODUCTO
    public static AgregarProductoJSON() {
      let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
      let origen: string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;

      xhttp.open("POST", "./backend/AltaProductoJSON.php", true);

      let form: FormData = new FormData();

      form.append("nombre", nombre);
      form.append("origen", origen);

      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = JSON.parse(xhttp.responseText);
          console.log(respuesta.mensaje);
          alert(respuesta.mensaje);
          PrimerParcial.Manejadora.MostrarProductosJSON();
        }
      };
    }

    public static MostrarProductosJSON() {
      xhttp.open("GET", "./BACKEND/ListadoProductosJSON.php", true);
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta: string = xhttp.responseText;
          let productosJson = JSON.parse(respuesta);

          const contenerdorTabla: HTMLDivElement = <HTMLDivElement>document.getElementById("divTabla");
          contenerdorTabla.innerHTML = "";

          // ARMADO DE TABLA
          const tabla: HTMLTableElement = document.createElement("table");

          // Armado de thead
          const thead = document.createElement("thead");
          for (const key in productosJson[0]) {
            const th = document.createElement("th");
            let text = document.createTextNode(key.toUpperCase());
            th.appendChild(text);
            thead.appendChild(th);
          }
          // Armado de tbody
          const tbody = document.createElement("tbody");
          productosJson.forEach((producto: any) => {
            const tr = document.createElement("tr");
            for (const key in producto) {
              const td = document.createElement("td");
              let text = document.createTextNode(producto[key]);
              td.appendChild(text);
              tr.appendChild(td);
            }
            tbody.appendChild(tr);
          });
          tabla.appendChild(thead);
          tabla.appendChild(tbody);
          contenerdorTabla.appendChild(tabla); // se inyecta toda la tabla en el contenedor
        }
      };
      xhttp.send();
    }

    public static VerificarProductoJSON() {
      let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
      let origen: string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;

      xhttp.open("POST", "./BACKEND/VerificarProductoJSON.php", true);

      let form: FormData = new FormData();
      form.append("nombre", nombre);
      form.append("origen", origen);
      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = JSON.parse(xhttp.responseText);
          console.log(respuesta.mensaje);
          alert(respuesta.mensaje);
        }
      };
    }

    public static MostrarInfoCookie() {
      let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
      let origen: string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;

      xhttp.open("GET", "./BACKEND/MostrarCookie.php?nombre=" + nombre + "&origen=" + origen, true);
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = JSON.parse(xhttp.responseText);
          const contenerdorInfo: HTMLDivElement = <HTMLDivElement>document.getElementById("divInfo");

          contenerdorInfo.innerText = respuesta.mensaje;
          console.log(respuesta.mensaje);
        }
      };
      xhttp.send();
    }

    // FUNCIONES PRODUCTO ENVASADO
    public static AgregarProductoSinFoto() {
      let codigoBarra: string = (<HTMLInputElement>document.getElementById("codigoBarra")).value;
      let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
      let origen: string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;
      let precio: number = parseInt((<HTMLInputElement>document.getElementById("precio")).value);
      let producto = new Entidades.ProductoEnvasado(nombre, origen, 0, codigoBarra, precio);

      xhttp.open("POST", "./backend/AgregarProductoSinFoto.php", true);

      let form: FormData = new FormData();
      form.append("producto_json", producto.ToJSON());
      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = JSON.parse(xhttp.responseText);
          console.log(respuesta.mensaje);
          alert(respuesta.mensaje);
        }
      };
    }

    public static MostrarProductosEnvasados(tipoTabla: number) {
      xhttp.open("GET", "./BACKEND/ListadoProductosEnvasados.php?tabla=json", true);
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta: string = xhttp.responseText;
          let productosJson = JSON.parse(respuesta);

          const contenerdorTabla: HTMLDivElement = <HTMLDivElement>document.getElementById("divTabla");
          contenerdorTabla.innerHTML = "";

          let tablaStr: string = `
          <table>
              <thead>`;
          for (const key in productosJson[0]) {
            tablaStr += `<th>${key.toLocaleUpperCase()}</th>`;
          }
          tablaStr += `<th>ACCIONES</th>`;
          tablaStr += `</thead>`;

          tablaStr += `<tbody>`;
          productosJson.forEach((producto: any) => {
            tablaStr += `<tr>`;
            for (const key in producto) {
              if (key != "pathFoto") {
                tablaStr += `<td>${producto[key]}</td>`;
              } else {
                tablaStr += `<td><img src='./BACKEND${producto[key]}' width='50px' alt='img'></td>`;
              }
            }
            let productoStr = JSON.stringify(producto);
            if (tipoTabla == 1) {
              tablaStr += `<td> <input type="button" value="Modificar" class="btn btn-info" onclick=PrimerParcial.Manejadora.BtnModificarProducto(${productoStr})></td>`;
              tablaStr += `<td> <input type="button" value="Eliminar" class="btn btn-danger" onclick=PrimerParcial.Manejadora.BtnEliminarProducto(${productoStr})></td>`;
            } else if (tipoTabla == 2) {
              tablaStr += `<td> <input type="button" value="Modificar" class="btn btn-info" onclick=PrimerParcial.Manejadora.BtnModificarProductoFoto(${productoStr})></td>`;
              tablaStr += `<td> <input type="button" value="Eliminar" class="btn btn-danger" onclick=PrimerParcial.Manejadora.BorrarProductoFoto(${productoStr})></td>`;
            }
            tablaStr += `</tr>`;
          });
          tablaStr += `</tbody>`;
          tablaStr += `</table>`;
          contenerdorTabla.innerHTML = tablaStr;
        }
      };
      xhttp.send();
    }

    // IMPLEMENTACION INTERFACE IPARTE2
    public EliminarProducto(obj: any): void {
      let confirmacion = confirm(`Desea eliminar el producto con nombre "${obj.nombre}" y origen
      "${obj.origen}" ?`);

      if (confirmacion) {
        xhttp.open("POST", "./BACKEND/EliminarProductoEnvasado.php", true);

        let form: FormData = new FormData();
        form.append("producto_json", JSON.stringify(obj));
        xhttp.send(form);

        xhttp.onreadystatechange = () => {
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            let respuesta = JSON.parse(xhttp.responseText);
            console.log(respuesta.mensaje);
            alert(respuesta.mensaje);
            Manejadora.MostrarProductosEnvasados(1);
          }
        };
      }
    }
    public static BtnEliminarProducto(obj: any): void {
      let manejadora = new Manejadora();
      manejadora.EliminarProducto(obj);
    }

    public ModificarProducto(obj: any): void {}

    public static ModificarProducto(obj: any): void {
      const inpId = <HTMLInputElement>document.getElementById("idProducto");
      const inpCodigoBarra = <HTMLInputElement>document.getElementById("codigoBarra");
      const inpNombre = <HTMLInputElement>document.getElementById("nombre");
      const inpCboOrigen = <HTMLSelectElement>document.getElementById("cboOrigen");
      const inpPrecio = <HTMLInputElement>document.getElementById("precio");

      let id: number = parseInt(inpId.value);
      let codigoBarra: string = inpCodigoBarra.value;
      let nombre: string = inpNombre.value;
      let origen: string = inpCboOrigen.value;
      let precio: number = parseInt(inpPrecio.value);
      const producto = {
        id: id,
        codigoBarra: codigoBarra,
        nombre: nombre,
        origen: origen,
        precio: precio,
      };

      xhttp.open("POST", "./BACKEND/ModificarProductoEnvasado.php", true);

      let form: FormData = new FormData();
      form.append("producto_json", JSON.stringify(producto));
      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = JSON.parse(xhttp.responseText);
          if (respuesta.exito) {
            Manejadora.MostrarProductosEnvasados(1);
          } else {
            console.log(respuesta.mensaje);
            alert(respuesta.mensaje);
          }
          inpId.disabled = false;
          inpId.value = "";
          inpCodigoBarra.value = "";
          inpNombre.value = "";
          inpCboOrigen.value = "";
          inpPrecio.value = "";
        }
      };
    }

    public static BtnModificarProducto(obj: any): void {
      (<HTMLInputElement>document.getElementById("idProducto")).value = obj.id;
      (<HTMLInputElement>document.getElementById("codigoBarra")).value = obj.codigoBarra;
      (<HTMLInputElement>document.getElementById("nombre")).value = obj.nombre;
      (<HTMLSelectElement>document.getElementById("cboOrigen")).value = obj.origen;
      (<HTMLInputElement>document.getElementById("precio")).value = obj.precio;
      (<HTMLInputElement>document.getElementById("idProducto")).disabled = true;
    }

    // IMPLEMETACION INTERFACE IPARTE3
    public static VerificarProductoEnvasado(): void {
      const inpNombre = <HTMLInputElement>document.getElementById("nombre");
      const inpCboOrigen = <HTMLSelectElement>document.getElementById("cboOrigen");
      let nombre = inpNombre.value;
      let origen = inpCboOrigen.value;
      let producto = { nombre: nombre, origen: origen };

      xhttp.open("POST", "./BACKEND/VerificarProductoEnvasado.php", true);

      let form: FormData = new FormData();
      form.append("obj_producto", JSON.stringify(producto));
      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = JSON.parse(xhttp.responseText);
          if (respuesta.id == undefined) {
            console.log("Producto no encontrado");
          } else {
            const contenerdorInfo: HTMLDivElement = <HTMLDivElement>document.getElementById("divInfo");
            contenerdorInfo.innerText = xhttp.responseText;
            console.log("Producto encontrado");
            console.log(respuesta);
          }
        }
      };
    }

    public static AgregarProductoFoto(): void {
      const inpCodigoBarra = <HTMLInputElement>document.getElementById("codigoBarra");
      const inpNombre = <HTMLInputElement>document.getElementById("nombre");
      const inpCboOrigen = <HTMLSelectElement>document.getElementById("cboOrigen");
      const inpPrecio = <HTMLInputElement>document.getElementById("precio");
      const foto: any = <HTMLInputElement>document.getElementById("foto");

      let codigoBarra: string = inpCodigoBarra.value;
      let nombre: string = inpNombre.value;
      let origen: string = inpCboOrigen.value;
      let precio: string = inpPrecio.value;

      xhttp.open("POST", "./BACKEND/AgregarProductoEnvasado.php", true);

      let form: FormData = new FormData();
      form.append("codigoBarra", codigoBarra);
      form.append("nombre", nombre);
      form.append("origen", origen);
      form.append("precio", precio);
      form.append("foto", foto.files[0]);

      xhttp.setRequestHeader("enctype", "multipart/form-data");

      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = JSON.parse(xhttp.responseText);
          console.log(respuesta.mensaje);
          alert(respuesta.mensaje);
          Manejadora.MostrarProductosEnvasados(2);
        }
      };
    }

    public static BorrarProductoFoto(obj: any): void {
      let confirmacion = confirm(`Desea eliminar el producto con nombre "${obj.nombre}" y origen
      "${obj.origen}" ?`);

      if (confirmacion) {
        xhttp.open("POST", "./BACKEND/BorrarProductoEnvasado.php", true);

        let form: FormData = new FormData();
        form.append("producto_json", JSON.stringify(obj));
        xhttp.send(form);

        xhttp.onreadystatechange = () => {
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            let respuesta = JSON.parse(xhttp.responseText);
            console.log(respuesta.mensaje);
            alert(respuesta.mensaje);
            Manejadora.MostrarProductosEnvasados(2);
          }
        };
      }
    }

    public static ModificarProductoFoto(): void {
      const inpId = <HTMLInputElement>document.getElementById("idProducto");
      const inpCodigoBarra = <HTMLInputElement>document.getElementById("codigoBarra");
      const inpNombre = <HTMLInputElement>document.getElementById("nombre");
      const inpCboOrigen = <HTMLSelectElement>document.getElementById("cboOrigen");
      const inpPrecio = <HTMLInputElement>document.getElementById("precio");
      let foto: any = <HTMLInputElement>document.getElementById("foto");

      let id: number = parseInt(inpId.value);
      let codigoBarra: string = inpCodigoBarra.value;
      let nombre: string = inpNombre.value;
      let origen: string = inpCboOrigen.value;
      let precio: number = parseInt(inpPrecio.value);
      const producto = {
        id: id,
        codigoBarra: codigoBarra,
        nombre: nombre,
        origen: origen,
        precio: precio,
      };

      xhttp.open("POST", "./BACKEND/ModificarProductoEnvasadoFoto.php", true);

      let form: FormData = new FormData();
      form.append("producto_json", JSON.stringify(producto));
      form.append("foto", foto.files[0]);
      xhttp.setRequestHeader("enctype", "multipart/form-data");
      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = JSON.parse(xhttp.responseText);
          if (respuesta.exito) {
            Manejadora.MostrarProductosEnvasados(2);
          } else {
            console.log(respuesta.mensaje);
            alert(respuesta.mensaje);
          }
          inpId.disabled = false;
          inpId.value = "";
          inpCodigoBarra.value = "";
          inpNombre.value = "";
          inpCboOrigen.value = "";
          inpPrecio.value = "";
        }
      };
    }

    public static BtnModificarProductoFoto(obj: any): void {
      (<HTMLInputElement>document.getElementById("idProducto")).value = obj.id;
      (<HTMLInputElement>document.getElementById("codigoBarra")).value = obj.codigoBarra;
      (<HTMLInputElement>document.getElementById("nombre")).value = obj.nombre;
      (<HTMLSelectElement>document.getElementById("cboOrigen")).value = obj.origen;
      (<HTMLInputElement>document.getElementById("precio")).value = obj.precio;
      (<HTMLInputElement>document.getElementById("idProducto")).disabled = true;
      const img = <HTMLImageElement>document.getElementById("imgFoto");
      img.src = "./BACKEND" + obj.pathFoto;
    }

    // IMPLEMENTACION INTERFACE IPARTE4
    public static MostrarBorradosJSON() {
      xhttp.open("GET", "./BACKEND/MostrarBorradosJSON.php", true);
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta: string = xhttp.responseText;
          let productosJson = JSON.parse(respuesta);
          const contenerdorInfo: HTMLDivElement = <HTMLDivElement>document.getElementById("divInfo");
          contenerdorInfo.innerHTML = respuesta;
          console.log(productosJson);
        }
      };
      xhttp.send();
    }

    public static MostrarFotosModificados() {
      xhttp.open("GET", "./BACKEND/MostrarFotosDeModificados.php", true);
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta: string = xhttp.responseText;
          const contenerdorInfo: HTMLDivElement = <HTMLDivElement>document.getElementById("divTabla");
          contenerdorInfo.innerHTML = respuesta;
        }
      };
      xhttp.send();
    }

    public static FiltrarListado() {
      const inpNombre = <HTMLInputElement>document.getElementById("nombre");
      const inpCboOrigen = <HTMLSelectElement>document.getElementById("cboOrigen");

      let nombre: string = inpNombre.value;
      let origen: string = inpCboOrigen.value;

      xhttp.open("POST", "./BACKEND/FiltrarProductos.php", true);

      let form: FormData = new FormData();
      form.append("nombre", nombre);
      form.append("origen", origen);
      xhttp.send(form);

      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let respuesta = xhttp.responseText;
          const contenerdorInfo: HTMLDivElement = <HTMLDivElement>document.getElementById("divTabla");
          contenerdorInfo.innerHTML = respuesta;
        }
      };
    }
  }
}
