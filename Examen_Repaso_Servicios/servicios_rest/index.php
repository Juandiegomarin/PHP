<?php

use Slim\Http\Response;

require __DIR__ . '/Slim/autoload.php';
require "src/ctes_func.php";
$app = new \Slim\App;

$app->get("/login",function($request){

    //$datos[]=$request->getParam("usuario");
   // $datos[]=$request->getParam("clave");
    $datos[]="juandi";
    $datos[]=md5("123456");

    echo json_encode(login($datos));

});

$app->run();
?>