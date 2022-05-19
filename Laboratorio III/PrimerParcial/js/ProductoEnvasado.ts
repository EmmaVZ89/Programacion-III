/// <reference path="./Producto.ts" />

namespace Entidades {
    export class ProductoEnvasado extends Producto {
      public id: number | undefined;
      public codigoBarra: string | undefined;
      public precio: number | undefined;
      public pathFoto: string | undefined;
  
      public constructor(
        nombre?: string,
        origen?: string,
        id?: number,
        codigoBarra?: string,
        precio?: number,
        pathFoto?: string
      ) {
        super(nombre, origen);
        this.id = id;
        this.codigoBarra = codigoBarra;
        this.precio = precio;
        this.pathFoto = pathFoto;
      }
  
      public ToJSON(): string {
        let retorno: string =
        "{" + super.ToString() + ", " +
        `"id":${this.id},` + 
        `"codigoBarra":"${this.codigoBarra}",` +
        `"precio":${this.precio},` + 
        `"pathFoto":"${this.pathFoto}"}`;
        return retorno;
      }
      
    }
  }
  