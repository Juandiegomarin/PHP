<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios Web</title>
</head>
<body>

<?php
define("DIR_SERV","http://localhost/Proyectos/TeoriaServiviosWeb/primera_api");
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
//Metodo get por arriba----------------------------------------------------------
$url=DIR_SERV."/saludo/".urlencode("Maria jose");
$respuesta=consumir_servicios_REST($url,"GET");

/*$respuesta=file_get_contents($url);*/
$obj=json_decode($respuesta);
if(!$obj) die("<p>Error consumiendo el servicio ".$url." </p>".$respuesta);

echo "<p>El saludo recibido ha sido <strong>".$obj->mensaje."</strong></p>";

//Metodo post por abajo----------------------------------------------------------
$url=DIR_SERV."/saludo";
$datos["param"]="Juan Diego";
$respuesta=consumir_servicios_REST($url,"POST",$datos);
$obj=json_decode($respuesta);
if(!$obj) die("<p>Error consumiendo el servicio ".$url." </p>".$respuesta);

echo "<p>El saludo recibido ha sido <strong>".$obj->mensaje."</strong></p>";

// Metodo borrar por arriba----------------------------------------------------------
$url=DIR_SERV."/borrar_saludo/24";
$datos["param"]="Juan Diego";
$respuesta=consumir_servicios_REST($url,"DELETE");
$obj=json_decode($respuesta);
if(!$obj) die("<p>Error consumiendo el servicio ".$url." </p>".$respuesta);

echo "<p>El saludo recibido ha sido <strong>".$obj->mensaje."</strong></p>";

$url=DIR_SERV."/actualizar_saludo/30";
$datos["nombre"]="Juan Diego";
$respuesta=consumir_servicios_REST($url,"PUT",$datos);
$obj=json_decode($respuesta);
if(!$obj) die("<p>Error consumiendo el servicio ".$url." </p>".$respuesta);

echo "<p>El saludo recibido ha sido <strong>".$obj->mensaje."</strong></p>";
?>
    
</body>
</html>