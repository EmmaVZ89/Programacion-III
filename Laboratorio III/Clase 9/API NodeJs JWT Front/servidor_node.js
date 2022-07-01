"use strict";
var express = require('express');
var app = express();
app.set('puerto', 9876);
app.get('/', function (request, response) {
    response.send('GET - servidor NodeJS');
});
var fs = require('fs');
app.use(express.json());
var jwt = require("jsonwebtoken");
app.set("key", "cl@ve_secreta");
app.use(express.urlencoded({ extended: false }));
var multer = require('multer');
var mime = require('mime-types');
var storage = multer.diskStorage({
    destination: "public/fotos/",
});
var upload = multer({
    storage: storage
});
var cors = require("cors");
app.use(cors());
app.use(express.static("public"));
var mysql = require('mysql');
var myconn = require('express-myconnection');
var db_options = {
    host: 'localhost',
    port: 3306,
    user: 'root',
    password: '',
    database: 'productos_usuarios_node'
};
app.use(myconn(mysql, db_options, 'single'));
var verificar_jwt = express.Router();
verificar_jwt.use(function (request, response, next) {
    var token = request.headers["x-access-token"] || request.headers["authorization"];
    if (!token) {
        response.status(401).send({
            error: "El JWT es requerido!!!"
        });
        return;
    }
    if (token.startsWith("Bearer ")) {
        token = token.slice(7, token.length);
    }
    if (token) {
        jwt.verify(token, app.get("key"), function (error, decoded) {
            if (error) {
                return response.json({
                    exito: false,
                    mensaje: "El JWT NO es válido!!!"
                });
            }
            else {
                console.log("middleware verificar_jwt");
                response.jwt = decoded;
                next();
            }
        });
    }
});
var solo_admin = express.Router();
solo_admin.use(verificar_jwt, function (request, response, next) {
    console.log("middleware solo_admin");
    var usuario = response.jwt;
    if (usuario.perfil == "administrador") {
        next();
    }
    else {
        return response.json({
            mensaje: "NO tiene perfil de 'ADMINISTRADOR'"
        });
    }
});
app.post("/crear_token", function (request, response) {
    if ((request.body.usuario == "admin" || request.body.usuario == "user") && request.body.clave == "123456") {
        var payload = {
            exito: true,
            usuario: request.body.usuario,
            perfil: request.body.usuario == "admin" ? "administrador" : "usuario",
        };
        var token = jwt.sign(payload, app.get("key"), {
            expiresIn: "1d"
        });
        response.json({
            mensaje: "JWT creado",
            jwt: token
        });
    }
    else {
        response.json({
            mensaje: "Usuario no registrado",
            jwt: null
        });
    }
});
app.get('/verificar_token', verificar_jwt, function (request, response) {
    response.json({ exito: true, jwt: response.jwt });
});
app.get('/admin', solo_admin, function (request, response) {
    response.json(response.jwt);
});
var verificar_usuario = express.Router();
verificar_usuario.use(function (request, response, next) {
    var obj = request.body;
    request.getConnection(function (err, conn) {
        if (err)
            throw ("Error al conectarse a la base de datos.");
        conn.query("select * from usuarios where legajo = ? and apellido = ? ", [obj.legajo, obj.apellido], function (err, rows) {
            if (err)
                throw ("Error en consulta de base de datos.");
            if (rows.length == 1) {
                response.obj_usuario = rows[0];
                next();
            }
            else {
                response.status(401).json({
                    exito: false,
                    mensaje: "Apellido y/o Legajo incorrectos.",
                    jwt: null
                });
            }
        });
    });
});
var alta_baja = express.Router();
alta_baja.use(verificar_jwt, function (request, response, next) {
    console.log("middleware alta_baja");
    var obj = response.jwt;
    if (obj.usuario.rol == "administrador") {
        next();
    }
    else {
        return response.status(401).json({
            mensaje: "NO tiene el rol necesario para realizar la acción."
        });
    }
});
var modificar = express.Router();
modificar.use(verificar_jwt, function (request, response, next) {
    console.log("middleware modificar");
    var obj = response.jwt;
    if (obj.usuario.rol == "administrador" || obj.usuario.rol == "supervisor") {
        next();
    }
    else {
        return response.status(401).json({
            mensaje: "NO tiene el rol necesario para realizar la acción."
        });
    }
});
app.post("/login", verificar_usuario, function (request, response, obj) {
    var user = response.obj_usuario;
    var payload = {
        usuario: {
            id: user.id,
            apellido: user.apellido,
            nombre: user.nombre,
            rol: user.rol
        },
        api: "productos_usuarios",
    };
    var token = jwt.sign(payload, app.get("key"), {
        expiresIn: "15m"
    });
    response.json({
        exito: true,
        mensaje: "JWT creado!!!",
        jwt: token
    });
});
app.get('/productos_bd', verificar_jwt, function (request, response) {
    request.getConnection(function (err, conn) {
        if (err)
            throw ("Error al conectarse a la base de datos.");
        conn.query("select * from productos", function (err, rows) {
            if (err)
                throw ("Error en consulta de base de datos.");
            response.send(JSON.stringify(rows));
        });
    });
});
app.post('/productos_bd', alta_baja, upload.single("foto"), function (request, response) {
    var file = request.file;
    var extension = mime.extension(file.mimetype);
    var obj = JSON.parse(request.body.obj);
    var path = file.destination + obj.codigo + "." + extension;
    fs.renameSync(file.path, path);
    obj.path = path.split("public/")[1];
    request.getConnection(function (err, conn) {
        if (err)
            throw ("Error al conectarse a la base de datos.");
        conn.query("insert into productos set ?", [obj], function (err, rows) {
            if (err) {
                console.log(err);
                throw ("Error en consulta de base de datos.");
            }
            response.send("Producto agregado a la bd.");
        });
    });
});
app.post('/productos_bd/modificar', modificar, upload.single("foto"), function (request, response) {
    var file = request.file;
    var extension = mime.extension(file.mimetype);
    var obj = JSON.parse(request.body.obj);
    var path = file.destination + obj.codigo + "." + extension;
    fs.renameSync(file.path, path);
    obj.path = path.split("public/")[1];
    var obj_modif = {};
    obj_modif.marca = obj.marca;
    obj_modif.precio = obj.precio;
    obj_modif.path = obj.path;
    request.getConnection(function (err, conn) {
        if (err)
            throw ("Error al conectarse a la base de datos.");
        conn.query("update productos set ? where codigo = ?", [obj_modif, obj.codigo], function (err, rows) {
            if (err) {
                console.log(err);
                throw ("Error en consulta de base de datos.");
            }
            response.send("Producto modificado en la bd.");
        });
    });
});
app.post('/productos_bd/eliminar', alta_baja, function (request, response) {
    var obj = request.body;
    var path_foto = "public/";
    request.getConnection(function (err, conn) {
        if (err)
            throw ("Error al conectarse a la base de datos.");
        conn.query("select path from productos where codigo = ?", [obj.codigo], function (err, result) {
            if (err)
                throw ("Error en consulta de base de datos.");
            path_foto += result[0].path;
        });
    });
    request.getConnection(function (err, conn) {
        if (err)
            throw ("Error al conectarse a la base de datos.");
        conn.query("delete from productos where codigo = ?", [obj.codigo], function (err, rows) {
            if (err) {
                console.log(err);
                throw ("Error en consulta de base de datos.");
            }
            fs.unlink(path_foto, function (err) {
                if (err)
                    throw err;
                console.log(path_foto + ' fue borrado.');
            });
            response.send("Producto eliminado de la bd.");
        });
    });
});
app.listen(app.get('puerto'), function () {
    console.log('Servidor corriendo sobre puerto:', app.get('puerto'));
});
//# sourceMappingURL=servidor_node.js.map