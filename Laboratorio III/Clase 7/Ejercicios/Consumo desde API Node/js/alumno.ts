namespace AJAX {
  export class Alumno {
    public legajo: number;
    public nombre: string;
    public apellido: string;
    public foto: string;

    public constructor(legajo: number, nombre: string, apellido: string, foto: string) {
      this.legajo = legajo;
      this.nombre = nombre;
      this.apellido = apellido;
      this.foto = foto;
    }

  }
}
