<?php

use Slim\Http\Response;

require __DIR__ . '/Slim/autoload.php';
require "src/ctes_func.php";
$app = new \Slim\App;

$app->get("/productos", function () {


    echo json_encode(productos());
});
$app->get("/producto/{codigo}", function ($request) {

    $cod = $request->getAttribute("codigo");
    echo json_encode(producto($cod));
});

$app->post("/producto/insertar", function ($request) {

    $cod = $request->getParam("cod");
    $nombre = $request->getParam("nombre");
    $nombre_corto = $request->getParam("nombre_corto");
    $descripcion = $request->getParam("descripcion");
    $pvp = $request->getParam("pvp");
    $familia = $request->getParam("familia");
    echo json_encode(insertar($cod, $nombre, $nombre_corto, $descripcion, $pvp, $familia));
});

$app->put("/producto/actualizar/{codigo}", function ($request) {

    $cod = $request->getAttribute("codigo");
    $nombre = $request->getParam("nombre");
    $nombre_corto = $request->getParam("nombre_corto");
    $descripcion = $request->getParam("descripcion");
    $pvp = $request->getParam("pvp");
    $familia = $request->getParam("familia");
    echo json_encode(actualizar($cod, $nombre, $nombre_corto, $descripcion, $pvp, $familia));
});

$app->delete("/producto/borrar/{codigo}", function ($request) {

    $cod = $request->getAttribute("codigo");
    echo json_encode(borrar($cod));
});
$app->get("/familias", function () {


    echo json_encode(familias());
});

$app->put("/repetido/{tabla}/{columna}/{valor}", function ($request) {

    $tabla = $request->getAttribute("tabla");
    $columna = $request->getParam("columna");
    $valor = $request->getParam("valor");

    echo json_encode(repetido($tabla, $columna, $valor));
});
//$app->post();
//$app->put();
//$app->delete();


$app->run();
/*$app->get("/saludo",function(){

    $respuesta["mensaje"]="Hola";
    echo json_encode($respuesta);
});

$app->get("/saludo/{nombre}",function($request){

    $valor_recibido=$request->getAttribute("nombre");
    $respuesta["mensaje"]="Hola ".$valor_recibido;
    echo json_encode($respuesta);
    
});
$app->post("/saludo",function($request){

    $valor_recibido=$request->getParam("param");
    $respuesta["mensaje"]="Hola ".$valor_recibido;
    echo json_encode($respuesta);
    
});

$app->delete("/borrar_saludo/{id}",function($request){

    $id_recibido=$request->getAttribute("id");
    $respuesta["mensaje"]="Se ha borrado el saludo con id: ".$id_recibido;
    echo json_encode($respuesta);
    
});

$app->put("/actualizar_saludo/{id}",function($request){
    $id_recibida=$request->getAttribute("id");
    $nombre_nuevo=$request->getParam("nombre");
    $respuesta["mensaje"]="Se ha borrado el saludo con id: ".$id_recibida." con nombre".$nombre_nuevo;
    echo json_encode($respuesta);
});


// Una vez creado servicios los pongo a disposición*/
