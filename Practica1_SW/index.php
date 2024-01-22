<?php

define("DIR_SERV","http://localhost/Proyectos/Practica1_SW/primera_api");
function consumir_servicios_REST($url,$metodo,$datos=null)
    {
        $llamada=curl_init();
        curl_setopt($llamada,CURLOPT_URL,$url);
        curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
        if(isset($datos))
            curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
        $respuesta=curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }

//Ejercicio 3
$url=DIR_SERV."/insertarProducto";
$producto["cod"]="1";
$producto["nombre"]="Producto1";
$producto["nombre_corto"]="Producto1";
$producto["descripcion"]="Producto1";
$producto["PVP"]=0;
$producto["familia"]="Producto1";

$respuesta=consumir_servicios_REST($url,"POST",$producto);
$obj=json_decode($respuesta);
if(!$obj) die("<p>Error consumiendo el servicio ".$url." </p>".$respuesta);

echo "<p>El saludo recibido ha sido <strong>".$obj->mensaje."</strong></p>";



?>