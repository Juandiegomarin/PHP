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

$app->get("/repetido/{tabla}/{columna}/{valor}", function ($request) {

    $tabla = $request->getAttribute("tabla");
    $columna = $request->getAttribute("columna");
    $valor = $request->getAttribute("valor");

    echo json_encode(repetido($tabla, $columna, $valor));
});
$app->get("/repetidoEditando/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}", function ($request) {

    $tabla = $request->getAttribute("tabla");
    $columna = $request->getAttribute("columna");
    $valor = $request->getAttribute("valor");
    $columna_id = $request->getAttribute("columna_id");
    $valor_id = $request->getAttribute("valor_id");

    echo json_encode(repetidoEditando($tabla, $columna, $valor,$columna_id,$valor_id));
});

$app->post("/login",function($request){

    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");

    echo json_encode(login($usuario,$clave));

});
//$app->post();
//$app->put();
//$app->delete();

$app->run();
?>