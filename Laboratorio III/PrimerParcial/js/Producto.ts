
namespace Entidades {
    export class Producto {
      public nombre: string | undefined;
      public origen: string | undefined;
  
      public constructor(
        nombre: string | undefined,
        origen: string | undefined
      ) {
        this.nombre = nombre;
        this.origen = origen;
      }
  
      public ToString(): string {
        let retorno: string = `"nombre":"${this.nombre}", "origen":"${this.origen}"`;
        return retorno;
      }
  
      public ToJSON() : string {
          let retorno = "{" + this.ToString() + "}";
          return retorno;
      }
  
    }
  }
  