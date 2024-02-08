<?php

use Slim\Http\Response;

require __DIR__ . '/Slim/autoload.php';
require "src/ctes_func.php";
$app = new \Slim\App;

$app->post("/login",function($request){

    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");


    echo json_encode(login($datos));

});

$app->post("/logeado",function($request){

    $token=$request->getParam("token");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"])){

        echo json_encode(logeado($_SESSION["usuario"],$_SESSION["clave"]));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes acceso a este servicio"));
    }

});
$app->post("/salir",function($request){

    $token=$request->getParam("token");
    session_id($token);
    session_start();
    session_destroy();

});
$app->post("/obtenerGrupo",function($request){

    $token=$request->getParam("token");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"])){
        $id_usuario=$request->getParam("id_usuario");
        $dia=$request->getParam("dia");
        $hora=$request->getParam("hora");
        echo json_encode(obtener_grupos($id_usuario,$dia,$hora));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes acceso a este servicio"));
    }
    

});
$app->get("/obtenerNombreGrupo/{id_grupo}",function($request){

    $token=$request->getParam("token");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"])){
        $id_grupo=$request->getAttribute("id_grupo");
        echo json_encode(obtener_nombre_grupo($id_grupo));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes acceso a este servicio"));
    }
    

});



$app->run();
?>