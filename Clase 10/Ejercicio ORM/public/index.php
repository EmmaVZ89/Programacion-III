<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;


require __DIR__ . '/../vendor/autoload.php';

//referenciar la clase del modelo
require_once '../app/models/alumno.php';

// y usar un alias para el namespace de la entidad Eloquent ORM
use \App\Models\alumno as alumnoORM;


$app = AppFactory::create();

$container = $app->getContainer();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
  'driver' => 'mysql',
  'host' => 'localhost',
  'database' => 'alumno_api_orm',
  'username' => 'root',
  'password' => '',
  'charset'   => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix'    => '',
]);

$capsule->bootEloquent();
$capsule->setAsGlobal();

$c = $container;
$c['errorHandler'] = function ($c) {

  return function ($request, $response, $exception) use ($c) {

    return $response->withStatus(500)
      ->withHeader('Content-Type', 'text/html')
      ->write('¡Error no controlado!');
  };
};

$c['notFoundHandler'] = function ($c) {

  return function ($request, $response) use ($c) {

    return $response->withStatus(404)
      ->withHeader('Content-Type', 'text/html')
      ->write('No es una ruta correcta.');
  };
};

$c['notAllowedHandler'] = function ($c) {

  return function ($request, $response, $methods) use ($c) {

    return $response->withStatus(405)
      ->withHeader('Allow', implode(', ', $methods))
      ->withHeader('Content-type', 'text/html')
      ->write('Sólo se puede por: ' . implode(', ', $methods));
  };
};

$c['phpErrorHandler'] = function ($c) {

  return function ($request, $response, $error) use ($c) {

    return $response->withStatus(500)
      ->withHeader('Content-Type', 'text/html')
      ->write('¡Algo está mal con tu PHP!');
  };
};


//************************************************************************************************************//
//ORM
//************************************************************************************************************//

/*LLAMADA a funciones del ORM*/
$app->group('/orm', function (RouteCollectorProxy $grupo) {

  //TRAER TODOS
  $grupo->get('/todos/', function (Request $request, Response $response, array $args): Response {
    // Traer todos los alumnos
    $array_alumnos = App\Models\alumno::all();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($array_alumnos->toJson());
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //TRAER EL PRIMERO
  $grupo->get('/primero/', function (Request $request, Response $response, array $args): Response {
    // Traer el primero
    $alumno = new \App\Models\alumno();

    $primero = $alumno->all()->first();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($primero->toJson());
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //TRAER EL ÚLTIMO
  $grupo->get('/ultimo/', function (Request $request, Response $response, array $args): Response {
    // Traer el último
    $alumno = new \App\Models\alumno();

    $ultimo = $alumno->all()->last();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($ultimo->toJson());
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //TRAER POR ID
  $grupo->get('/{id}', function (Request $request, Response $response, array $args): Response {
    // Traer un alumno por id
    $id = $args["id"];

    $alumno = new \App\Models\alumno();

    $un_alumno = $alumno->find($id);

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($un_alumno->toJson());
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //TRAER POR NOMBRE
  $grupo->get('/nombre/{nombre}', function (Request $request, Response $response, array $args): Response {
    // Traer un alumno por nombre
    $nombre = $args["nombre"];

    $alumno = new \App\Models\alumno();

    $array_alumnos = $alumno->where('nombre', $nombre)->get();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($array_alumnos->toJson());
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //AGREGAR
  $grupo->post('/', function (Request $request, Response $response, array $args): Response {
    $parametros = $request->getParsedBody();
    $obj_json = json_decode($parametros["obj_json"]);

    $alumno = new alumnoORM();

    $alumno->legajo = $obj_json->legajo;
    $alumno->nombre = $obj_json->nombre;
    $alumno->apellido = $obj_json->apellido;
    $alumno->foto = $obj_json->foto;

    $alumno->save();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($alumno->toJson());
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //MODIFICAR
  $grupo->patch('/{cadenaJson}', function (Request $request, Response $response, array $args): Response {
    $obj_json = json_decode($args["cadenaJson"]);
    $id = $obj_json->id;

    $alumno = new alumnoORM();

    $un_alumno = $alumno->find($id);

    $un_alumno->legajo = $obj_json->legajo;
    $un_alumno->nombre = $obj_json->nombre;
    $un_alumno->apellido = $obj_json->apellido;
    $un_alumno->foto = $obj_json->foto;

    $un_alumno->save();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($un_alumno->toJson());
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //BORRAR    
  $grupo->delete('/{id}', function (Request $request, Response $response, array $args): Response {
    $id = $args["id"];

    $alumno = new alumnoORM();

    $alumno->find($id)->delete();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write(json_encode("Borrado!!!"));
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //EJECUTAR QUERY CON FUNCIONES DE AGREGADO
  $grupo->get('/funciones/agregado/', function (Request $request, Response $response, array $args): Response {
    $mensaje = "Funciones de agregado (count, max, min, avg, y sum). <br>";

    $cantidad_alumnos = alumnoORM::all()->count();
    $legajo_mayor = alumnoORM::all()->max("legajo");
    $legajo_menor = alumnoORM::all()->min("legajo");
    $suma_legajos = alumnoORM::all()->sum("legajo");
    $promedio_legajos = alumnoORM::all()->avg("legajo");

    $mensaje .= "Total: {$cantidad_alumnos} - legajo mayor: {$legajo_mayor} - legajo menor: {$legajo_menor} " .
      "- sumatoria de legajo: {$suma_legajos} - promedio de legajo: {$promedio_legajos}";

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write(json_encode($mensaje));
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //https://laravel.com/docs/8.x/queries

  //EJECUTAR QUERY
  $grupo->get('/query/', function (Request $request, Response $response, array $args): Response {
    $alumnos = Capsule::table('alumnos')->where('legajo', '>', 6)->get();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($alumnos->toJson());

    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //EJECUTAR QUERY COMPLETA
  $grupo->get('/query/completa/', function (Request $request, Response $response, array $args): Response {
    // Ejecuta query completa desde Capsule
    $alumnos = Capsule::table('alumnos')->where('legajo', '>', 6)
      ->whereIn('id', [1017, 1026, 1041])
      ->where('nombre', 'like', 'L%')
      ->orWhere('apellido', 'Quiroz')
      ->orWhere(function ($query) {
        $query->whereDate('created_at', '>', '2021-03-01')
          ->whereNull('updated_at');
      })
      ->orderBy('nombre')
      ->limit(3)
      ->get();

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write($alumnos->toJson());
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //EJECUTAR CONSULTA COMO SQL 
  $grupo->get('/select_sql/', function (Request $request, Response $response, array $args): Response {
    $mensaje = "Ejecuta query desde Capsule, como consulta sql. <br>";
    $rs = Capsule::select('select * from alumnos where id >= ?', [1]);

    foreach ($rs as $value) {

      $mensaje .= $value->id . " - " . $value->legajo . " - " . $value->nombre . " - " . $value->apellido . "<br>";
    }

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write(json_encode($mensaje));
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  //EJECUTAR CONSULTA PARA ABM 
  $grupo->post('/query_abm/', function (Request $request, Response $response, array $args): Response {
    $parametros = $request->getParsedBody();
    $obj_json = json_decode($parametros["obj_json"]);

    $mensaje = "Agregar alumno desde query. <br>";

    $id_agregado = Capsule::table('alumnos')->insertGetId([
      'legajo' => $obj_json->legajo,
      'nombre' => $obj_json->nombre,
      'apellido' => $obj_json->apellido,
      'foto' => $obj_json->foto
    ]);

    $mensaje .= "ID del nuevo registro: {$id_agregado}";

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write(json_encode($mensaje));

    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  $grupo->patch('/query_abm/', function (Request $request, Response $response, array $args): Response {
    parse_str(file_get_contents("php://input"), $put_vars);
    $obj_json = json_decode($put_vars['obj_json']);

    $mensaje = "Modificar alumno desde query. <br>";

    $cantidad_filas_afectadas = Capsule::table('alumnos')->where('id', $obj_json->id)
      ->update([
        'legajo' => $obj_json->legajo,
        'nombre' => $obj_json->nombre,
        'apellido' => $obj_json->apellido,
        'foto' => $obj_json->foto
        ]);

    $mensaje .= "Cantidad de filas afectadas = {$cantidad_filas_afectadas}";

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write(json_encode($mensaje));
    return $newResponse->withHeader('Content-Type', 'application/json');
  });

  $grupo->delete('/query_abm/', function (Request $request, Response $response, array $args): Response {
    parse_str(file_get_contents("php://input"), $put_vars);
    $obj_json = json_decode($put_vars['obj_json']);

    $mensaje = "Borrar alumno desde query. <br>";

    $cantidad_filas_afectadas = Capsule::table('alumnos')->where('id', $obj_json->id)->delete();

    $mensaje .= "Cantidad de filas afectadas = {$cantidad_filas_afectadas}";

    $newResponse = $response->withStatus(200);
    $newResponse->getBody()->write(json_encode($mensaje));
    return $newResponse->withHeader('Content-Type', 'application/json');
  });
});


//CORRE LA APLICACIÓN.
$app->run();
