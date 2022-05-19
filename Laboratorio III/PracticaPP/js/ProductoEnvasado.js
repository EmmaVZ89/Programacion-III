"use strict";
/// <reference path="./Producto.ts" />
var Entidades;
(function (Entidades) {
    class ProductoEnvasado extends Entidades.Producto {
        constructor(nombre, origen, id, codigoBarra, precio, pathFoto) {
            super(nombre, origen);
            this.id = id;
            this.codigoBarra = codigoBarra;
            this.precio = precio;
            this.pathFoto = pathFoto;
        }
        ToJSON() {
            let retorno = "{" + super.ToString() + ", " +
                `"id":${this.id},` +
                `"codigoBarra":"${this.codigoBarra}",` +
                `"precio":${this.precio},` +
                `"pathFoto":"${this.pathFoto}"}`;
            return retorno;
        }
    }
    Entidades.ProductoEnvasado = ProductoEnvasado;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=ProductoEnvasado.js.map