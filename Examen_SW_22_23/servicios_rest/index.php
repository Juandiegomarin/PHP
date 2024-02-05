<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;



/*$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

$app->get('/conexion_MYSQLI',function($request){
    
    echo json_encode(conexion_mysqli());
});
*/

$app->post("/login", function ($request) {

    $usuario = $request->getParam("lector");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get("/libros", function ($request) {

    echo json_encode(libros());
});

$app->post("/logeado", function ($request) {

    $token = $request->getParam("token");
    session_id($token);
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logeado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        echo json_encode(array("no_login" => "No logeado"));
    }
});
$app->get('/repetido/{tabla}/{columna}/{valor}',function($request){

    echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor')));
});
$app->post('/crearLibro',function($request){

    $datos[]=$request->getParam('referencia'); 
    $datos[]=$request->getParam('titulo');    
    $datos[]=$request->getParam('autor');
    $datos[]=$request->getParam('descripcion');
    $datos[]=$request->getParam('precio');

    echo json_encode(insertar_libro($datos));
});

$app->get('/obtenerLibro/{referencia}',function($request){

   $referencia=$request->getAttribute('referencia');

    echo json_encode(obtener_libro($referencia));
});

// Una vez creado servicios los pongo a disposición
$app->run();
