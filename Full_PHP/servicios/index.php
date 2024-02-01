<?php
require "src/funciones_ctes.php";


require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


$app->get('/usuarios',function(){

    echo json_encode(obtener_usuarios());
});

$app->get('/usuario/{id_usuario}',function($request){

    echo json_encode(obtener_usuario($request->getAttribute("id_usuario")));
});

$app->post('/crearUsuario',function($request){

    $datos[]=$request->getParam('nombre'); 
    $datos[]=$request->getParam('usuario');    
    $datos[]=$request->getParam('clave');
    $datos[]=$request->getParam('email');

    echo json_encode(insertar_usuario($datos));
});


$app->post('/login',function($request){

    $usuario=$request->getParam('usuario');    
    $clave=$request->getParam('clave');

    echo json_encode(login($usuario,$clave));
});



$app->post("/logeado",function($request){

    $token = $request->getParam("token");
    session_id($token);
    session_start();
    if(isset($_SESSION["usuario"])){
        echo json_encode(logeado($_SESSION["usuario"],$_SESSION["clave"]));
    }else{
        echo json_encode(array("no_login"=> "No logeado"));
    }
    
});



$app->put('/actualizarUsuario/{id_usuario}',function($request){

    $datos[]=$request->getParam('nombre'); 
    $datos[]=$request->getParam('usuario');    
    $datos[]=$request->getParam('clave');
    $datos[]=$request->getParam('email');
    $datos[]=$request->getAttribute('id_usuario');

    echo json_encode(actualizar_usuario($datos));
});

$app->put('/actualizarUsuarioSinClave/{id_usuario}',function($request){

    $datos[]=$request->getParam('nombre'); 
    $datos[]=$request->getParam('usuario');    
    $datos[]=$request->getParam('email');
    $datos[]=$request->getAttribute('id_usuario');

    echo json_encode(actualizar_usuario_sin_clave($datos));
});

$app->delete('/borrarUsuario/{id_usuario}',function($request){

    echo json_encode(borrar_usuario($request->getAttribute('id_usuario')));
});

$app->get('/repetido/{tabla}/{columna}/{valor}',function($request){

    echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor')));
});

$app->get('/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}',function($request){

    echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor'),$request->getAttribute('columna_id'),$request->getAttribute('valor_id')));
});


$app->run();

?>