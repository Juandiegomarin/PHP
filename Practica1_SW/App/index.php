<?php

define("DIR_SERV", "http://localhost/Proyectos/Practica1_SW/servicios_rest");
function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}
//Ejercicio 1
echo "---------------------------------------Ejercicio1------------------------------------------------";
$url = DIR_SERV . "/productos";
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
//echo "<p>El saludo recibido ha sido <strong>" . $obj->productos . "</strong></p>";
echo "<ol>";
foreach ($obj->productos as $producto) {
    echo "<li>".$producto->nombre_corto."</li>";
}
echo "</ol>";


//Ejercicio2
echo "---------------------------------------Ejercicio2------------------------------------------------";
$url = DIR_SERV . "/producto/ACERAX3950";
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
//echo "<p>El saludo recibido ha sido <strong>" . $obj->producto . "</strong></p>";
echo "<p>Este es el producto:".$obj->producto->nombre_corto."</p>";
//Ejercicio 3
echo "---------------------------------------Ejercicio3------------------------------------------------";

$url = DIR_SERV . "/producto/insertar";

$dato["cod"] = "XXXXX";
$dato["nombre"] = "Producto1";
$dato["nombre_corto"] = "Producto2";
$dato["descripcion"] = "Producto1";
$dato["pvp"] = 1;
$dato["familia"] = "CAMARA";

$respuesta = consumir_servicios_REST($url, "POST", $dato);
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);

echo "<p>".$obj->mensaje."</p>";

//Ejercicio 4
echo "---------------------------------------Ejercicio4------------------------------------------------";
$url = DIR_SERV . "/producto/actualizar/XXXXX";

$datos["nombre"] = "nombre_aux";
$datos["nombre_corto"] = "nombre_au";
$datos["descripcion"] = "nombre_aux";
$datos["pvp"] = 2;
$datos["familia"] = "CAMARA";

$respuesta = consumir_servicios_REST($url, "PUT", $datos);
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
//echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";

echo "<p>".$obj->mensaje."</p>";
//Ejercicio 5
echo "---------------------------------------Ejercicio5------------------------------------------------";
$url = DIR_SERV . "/producto/borrar/XXXXX";

$respuesta = consumir_servicios_REST($url, "DELETE");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
//echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";
echo "<p>".$obj->mensaje."</p>";
//Ejercicio 6
echo "---------------------------------------Ejercicio6------------------------------------------------";
$url = DIR_SERV . "/familias";
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
//echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";
echo "<p>Todas las familias</p>";

//Ejercicio 7
echo "---------------------------------------Ejercicio7------------------------------------------------";
$url = DIR_SERV . "/repetido/usuarios/usuario/dwes";
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
echo "<p>El saludo recibido ha sido <strong>" . $obj->repetido . "</strong></p>";
