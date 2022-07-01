"use strict";
const express = require("express");
const app = express();
app.set("puerto", 2022);
// app.get('/', (request:any, response:any)=>{
//     response.send('GET - servidor NodeJS');
// });
//AGREGO FILE SYSTEM
const fs = require("fs");
//AGREGO JSON
app.use(express.json());
//AGREGO JWT
const jwt = require("jsonwebtoken");
//SE ESTABLECE LA CLAVE SECRETA PARA EL TOKEN
app.set("key", "cl@ve_secreta");
app.use(express.urlencoded({ extended: false }));
//AGREGO MULTER
const multer = require("multer");
//AGREGO MIME-TYPES
const mime = require("mime-types");
//AGREGO STORAGE
const storage = multer.diskStorage({
    destination: "public/fotos/",
});
const upload = multer({
    storage: storage,
});
//AGREGO CORS (por default aplica a http://localhost)
const cors = require("cors");
//AGREGO MW
app.use(cors());
//DIRECTORIO DE ARCHIVOS ESTÁTICOS
app.use(express.static("public"));
//AGREGO MYSQL y EXPRESS-MYCONNECTION
const mysql = require("mysql");
const myconn = require("express-myconnection");
const db_options = {
    host: "localhost",
    port: 3306,
    user: "root",
    password: "",
    database: "jugueteria_bd",
};
app.use(myconn(mysql, db_options, "single"));
//##############################################################################################//
//RUTAS Y MIDDLEWATE PARA EL SERVIDOR DE AUTENTICACIÓN DE USUARIO Y JWT
//##############################################################################################//
const verificar_usuario = express.Router();
const verificar_jwt = express.Router();
const alta_baja = express.Router();
const modificar = express.Router();
verificar_usuario.use((request, response, next) => {
    let obj = request.body;
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("SELECT * FROM usuarios WHERE correo = ? and clave = ? ", [obj.correo, obj.clave], (err, rows) => {
            if (err)
                throw "Error en consulta de base de datos.";
            if (rows.length == 1) {
                response.obj_usuario = rows[0];
                //SE INVOCA AL PRÓXIMO CALLEABLE
                next();
            }
            else {
                response.status(401).json({
                    exito: false,
                    mensaje: "Correo y/o Clave incorrectos.",
                    jwt: null,
                });
            }
        });
    });
});
app.post("/login", verificar_usuario, (request, response, obj) => {
    //SE RECUPERA EL USUARIO DEL OBJETO DE LA RESPUESTA
    const user = response.obj_usuario;
    //SE CREA EL PAYLOAD CON LOS ATRIBUTOS QUE NECESITAMOS
    const payload = {
        usuario: {
            id: user.id,
            correo: user.correo,
            nombre: user.nombre,
            apellido: user.apellido,
            foto: user.foto,
            perfil: user.perfil,
        },
        alumno: {
            nombre: "Emmanuel",
            apellido: "Zelarayan",
        },
        parcial: "Segundo Parcial 2022 1C",
    };
    //SE FIRMA EL TOKEN CON EL PAYLOAD Y LA CLAVE SECRETA
    const token = jwt.sign(payload, app.get("key"), {
        expiresIn: "4m",
    });
    response.json({
        exito: true,
        mensaje: "JWT creado!!!",
        jwt: token,
    });
});
verificar_jwt.use((request, response, next) => {
    //SE RECUPERA EL TOKEN DEL ENCABEZADO DE LA PETICIÓN
    let token = request.headers["x-access-token"] || request.headers["authorization"];
    if (!token) {
        response.status(401).send({
            error: "El JWT es requerido!!!",
        });
        return;
    }
    if (token.startsWith("Bearer ")) {
        token = token.slice(7, token.length);
    }
    if (token) {
        //SE VERIFICA EL TOKEN CON LA CLAVE SECRETA
        jwt.verify(token, app.get("key"), (error, decoded) => {
            if (error) {
                return response.json({
                    exito: false,
                    mensaje: "El JWT NO es válido!!!",
                });
            }
            else {
                console.log("middleware verificar_jwt");
                //SE AGREGA EL TOKEN AL OBJETO DE LA RESPUESTA
                response.jwt = decoded;
                //SE INVOCA AL PRÓXIMO CALLEABLE
                next();
            }
        });
    }
});
// falta verificar_jwt
app.get("/login", (request, response) => {
    // response.json({exito:true, payload: response.jwt});
    let obj_respuesta = {
        exito: false,
        mensaje: "El JWT es requerido!!!",
        payload: null,
        status: 403,
    };
    //SE RECUPERA EL TOKEN DEL ENCABEZADO DE LA PETICIÓN
    let token = request.headers["x-access-token"] || request.headers["authorization"];
    if (!token) {
        response.status(obj_respuesta.status).json({
            obj_respuesta,
        });
    }
    if (token.startsWith("Bearer ")) {
        token = token.slice(7, token.length);
    }
    if (token) {
        //SE VERIFICA EL TOKEN CON LA CLAVE SECRETA
        jwt.verify(token, app.get("key"), (error, decoded) => {
            if (error) {
                obj_respuesta.mensaje = "El JWT NO es válido!!!";
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
            else {
                obj_respuesta.exito = true;
                obj_respuesta.mensaje = "El JWT es valido";
                obj_respuesta.payload = decoded;
                obj_respuesta.status = 200;
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
        });
    }
});
alta_baja.use(verificar_jwt, (request, response, next) => {
    console.log("middleware alta_baja");
    //SE RECUPERA EL TOKEN DEL OBJETO DE LA RESPUESTA
    let obj = response.jwt;
    console.log(obj.usuario);
    if (obj.usuario.perfil == "propietario") {
        //SE INVOCA AL PRÓXIMO CALLEABLE
        next();
    }
    else {
        return response.status(401).json({
            mensaje: "NO tiene el perfil necesario para realizar la acción.",
        });
    }
});
modificar.use(verificar_jwt, (request, response, next) => {
    console.log("middleware modificar");
    //SE RECUPERA EL TOKEN DEL OBJETO DE LA RESPUESTA
    let obj = response.jwt;
    if (obj.usuario.perfil == "propietario" || obj.usuario.perfil == "supervisor") {
        //SE INVOCA AL PRÓXIMO CALLEABLE
        next();
    }
    else {
        return response.status(401).json({
            mensaje: "NO tiene el perfil necesario para realizar la acción.",
        });
    }
});
// CRUD USUARIOS **************************************************************************************
// Agregar usuario
// falta middleware alta_baja
app.post("/usuarios", upload.single("foto"), (request, response) => {
    let obj_respuesta = {
        exito: false,
        mensaje: "No se pudo agregar el usuario",
        status: 418,
    };
    let file = request.file;
    let extension = mime.extension(file.mimetype);
    let usuario = JSON.parse(request.body.usuario);
    let path = file.destination + usuario.correo + "." + extension;
    fs.renameSync(file.path, path);
    usuario.foto = path.split("public/")[1];
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("INSERT INTO usuarios set ?", [usuario], (err, rows) => {
            if (err) {
                console.log(err);
                throw "Error en consulta de base de datos.";
            }
            obj_respuesta.exito = true;
            obj_respuesta.mensaje = "Usuario agregado!";
            obj_respuesta.status = 200;
            response.status(obj_respuesta.status).json(obj_respuesta);
        });
    });
});
// Listar usuarios OK
// falta verificar_jwt
app.get("/listarUsuariosBD", verificar_jwt, (request, response) => {
    let obj_respuesta = {
        exito: false,
        mensaje: "No se encontraron usuarios",
        dato: {},
        status: 424,
    };
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("SELECT * FROM usuarios", (err, rows) => {
            if (err)
                throw "Error en consulta de base de datos.";
            if (rows.length == 0) {
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
            else {
                obj_respuesta.exito = true;
                obj_respuesta.mensaje = "Usuarios encontrados!";
                obj_respuesta.dato = rows;
                obj_respuesta.status = 200;
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
        });
    });
});
// Modificar usuario
app.post("/usuarios/modificar", upload.single("foto"), modificar, (request, response) => {
    let obj_respuesta = {
        exito: false,
        mensaje: "No se pudo modificar el usuario",
        status: 418,
    };
    let file = request.file;
    let extension = mime.extension(file.mimetype);
    let usuario = JSON.parse(request.body.usuario);
    let path = file.destination + usuario.correo + "." + extension;
    fs.renameSync(file.path, path);
    usuario.foto = path.split("public/")[1];
    let usuario_modif = {};
    //para excluir la pk (id)
    usuario_modif.correo = usuario.correo;
    usuario_modif.clave = usuario.clave;
    usuario_modif.nombre = usuario.nombre;
    usuario_modif.apellido = usuario.apellido;
    usuario_modif.perfil = usuario.perfil;
    usuario_modif.foto = usuario.foto;
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("UPDATE usuarios set ?  WHERE id = ?", [usuario_modif, usuario.id], (err, rows) => {
            if (err) {
                console.log(err);
                throw "Error en consulta de base de datos.";
            }
            if (rows.affectedRows == 0) {
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
            else {
                obj_respuesta.exito = true;
                obj_respuesta.mensaje = "Usuario modificado!";
                obj_respuesta.status = 200;
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
        });
    });
});
// Eliminar usuario
app.post("/usuarios/eliminar", alta_baja, (request, response) => {
    let obj_respuesta = {
        exito: false,
        mensaje: "No se pudo eliminar el usuario",
        status: 418,
    };
    let obj = request.body;
    let path_foto = "public/";
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        // obtengo el path de la foto del usuario a ser eliminado
        conn.query("SELECT foto FROM usuarios WHERE id = ?", [obj.id], (err, result) => {
            if (err)
                throw "Error en consulta de base de datos.";
            if (result.length != 0) {
                //console.log(result[0].foto);
                path_foto += result[0].foto;
            }
        });
    });
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("DELETE FROM usuarios WHERE id = ?", [obj.id], (err, rows) => {
            if (err) {
                console.log(err);
                throw "Error en consulta de base de datos.";
            }
            if (fs.existsSync(path_foto) && path_foto != "public/") {
                fs.unlink(path_foto, (err) => {
                    if (err)
                        throw err;
                    console.log(path_foto + " fue borrado.");
                });
            }
            if (rows.affectedRows == 0) {
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
            else {
                obj_respuesta.exito = true;
                obj_respuesta.mensaje = "Usuario Eliminado!";
                obj_respuesta.status = 200;
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
        });
    });
});
// CRUD JUGUETES **************************************************************************************
// Agregar juguete
// falta alta_baja
app.post("/agregarJugueteBD", upload.single("foto"), verificar_jwt, (request, response) => {
    let obj_respuesta = {
        exito: false,
        mensaje: "No se pudo agregar el juguete",
        status: 418,
    };
    let file = request.file;
    let extension = mime.extension(file.mimetype);
    let juguete_json = JSON.parse(request.body.juguete_json);
    let path = file.destination + juguete_json.marca + "." + extension;
    fs.renameSync(file.path, path);
    juguete_json.path_foto = path.split("public/")[1];
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("INSERT INTO juguetes set ?", [juguete_json], (err, rows) => {
            if (err) {
                console.log(err);
                throw "Error en consulta de base de datos.";
            }
            obj_respuesta.exito = true;
            obj_respuesta.mensaje = "Juguete agregado!";
            obj_respuesta.status = 200;
            response.status(obj_respuesta.status).json(obj_respuesta);
        });
    });
});
// Listar juguete
// falta verificar_jwt
app.get("/listarJuguetesBD", verificar_jwt, (request, response) => {
    let obj_respuesta = {
        exito: false,
        mensaje: "No se encontraron juguetes",
        dato: {},
        status: 424,
    };
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("SELECT * FROM juguetes", (err, rows) => {
            if (err)
                throw "Error en consulta de base de datos.";
            if (rows.length == 0) {
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
            else {
                obj_respuesta.exito = true;
                obj_respuesta.mensaje = "Juguetes encontrados!";
                obj_respuesta.dato = rows;
                obj_respuesta.status = 200;
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
        });
    });
});
// Modificar juguete
// falta modificar
app.post("/toys", upload.single("foto"), verificar_jwt, (request, response) => {
    let obj_respuesta = {
        exito: false,
        mensaje: "No se pudo modificar el juguete",
        status: 418,
    };
    let file = request.file;
    let extension = mime.extension(file.mimetype);
    let juguete = JSON.parse(request.body.juguete);
    let path = file.destination + juguete.marca + "_modificacion" + "." + extension;
    fs.renameSync(file.path, path);
    juguete.path_foto = path.split("public/")[1];
    let jueguete_modif = {};
    //para excluir la pk (id)
    jueguete_modif.marca = juguete.marca;
    jueguete_modif.precio = juguete.precio;
    jueguete_modif.path_foto = juguete.path_foto;
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("UPDATE juguetes set ?  WHERE id = ?", [jueguete_modif, juguete.id_juguete], (err, rows) => {
            if (err) {
                console.log(err);
                throw "Error en consulta de base de datos.";
            }
            if (rows.affectedRows == 0) {
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
            else {
                obj_respuesta.exito = true;
                obj_respuesta.mensaje = "Juguete modificado!";
                obj_respuesta.status = 200;
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
        });
    });
});
// Eliminar juguete
// falta alta_baja
app.delete("/toys", verificar_jwt, (request, response) => {
    let obj_respuesta = {
        exito: false,
        mensaje: "No se pudo eliminar el juguete",
        status: 418,
    };
    let id = request.body.id_juguete;
    let obj = {};
    obj.id = id;
    let path_foto = "public/";
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        // obtengo el path de la foto del usuario a ser eliminado
        conn.query("SELECT path_foto FROM juguetes WHERE id = ?", [obj.id], (err, result) => {
            if (err)
                throw "Error en consulta de base de datos.";
            if (result.length != 0) {
                //console.log(result[0].foto);
                path_foto += result[0].path_foto;
            }
        });
    });
    request.getConnection((err, conn) => {
        if (err)
            throw "Error al conectarse a la base de datos.";
        conn.query("DELETE FROM juguetes WHERE id = ?", [obj.id], (err, rows) => {
            if (err) {
                console.log(err);
                throw "Error en consulta de base de datos.";
            }
            if (fs.existsSync(path_foto) && path_foto != "public/") {
                fs.unlink(path_foto, (err) => {
                    if (err)
                        throw err;
                    console.log(path_foto + " fue borrado.");
                });
            }
            if (rows.affectedRows == 0) {
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
            else {
                obj_respuesta.exito = true;
                obj_respuesta.mensaje = "Juguete Eliminado!";
                obj_respuesta.status = 200;
                response.status(obj_respuesta.status).json(obj_respuesta);
            }
        });
    });
});
app.listen(app.get("puerto"), () => {
    console.log("Servidor corriendo sobre puerto:", app.get("puerto"));
});
//# sourceMappingURL=servidor.js.map