<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post("/login",function($request){

    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("clave");

    echo json_encode(login($datos));
});
$app->get("/logueado",function($request){
    
    $token=$request->getParam("api_session");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"])){

        echo json_encode(logueado($_SESSION["usuario"],$_SESSION["clave"]));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes autorizacion para usar este servicio"));
    }
});

$app->get("/notasAlumno/{cod_alu}",function($request){

    $token=$request->getParam("api_session");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"])){

        $cod_alum=$request->getAttribute("cod_alu");
        echo json_encode(notasDeAlumno($cod_alum));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes autorizacion para usar este servicio"));
    }
});
$app->get("/alumnos",function($request){

    $token=$request->getParam("api_session");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor"){
        echo json_encode(alumnos());
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes autorizacion para usar este servicio"));
    }
});
$app->delete("/quitarNota/{cod_alu}",function($request){

    $token=$request->getParam("api_session");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor"){

        $datos[]=$request->getParam("cod_asig");
        $datos[]=$request->getAttribute("cod_alu");
        echo json_encode(quitarNota($datos));
    }else{
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes autorizacion para usar este servicio"));
    }
});
/*$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

$app->get('/conexion_MYSQLI',function($request){
    
    echo json_encode(conexion_mysqli());
});
*/


// Una vez creado servicios los pongo a disposición
$app->run();
?>
