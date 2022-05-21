"use strict";
var AJAX;
(function (AJAX) {
    class Alumno {
        constructor(legajo, nombre, apellido, foto) {
            this.legajo = legajo;
            this.nombre = nombre;
            this.apellido = apellido;
            this.foto = foto;
        }
    }
    AJAX.Alumno = Alumno;
})(AJAX || (AJAX = {}));
//# sourceMappingURL=alumno.js.map