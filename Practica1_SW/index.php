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
$obj="Lista de productos";
//echo "<p>El saludo recibido ha sido <strong>" . $obj->productos . "</strong></p>";
echo "<p>Insertado con exito</p>";


//Ejercicio2
echo "---------------------------------------Ejercicio2------------------------------------------------";
$url = DIR_SERV . "/producto/3DSNG";
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
//echo "<p>El saludo recibido ha sido <strong>" . $obj->producto . "</strong></p>";
echo "<p>Este es el producto</p>";
//Ejercicio 3
echo "---------------------------------------Ejercicio3------------------------------------------------";
$url = DIR_SERV . "/producto/insertar";
$producto["cod"] = "YYYYYY";
$producto["nombre"] = "Producto1";
$producto["nombre_corto"] = "Producto1";
$producto["descripcion"] = "Producto1";
$producto["pvp"] = 1;
$producto["familia"] = "CAMARA";

$respuesta = consumir_servicios_REST($url, "POST", $producto);
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";

//Ejercicio 4
echo "---------------------------------------Ejercicio4------------------------------------------------";
$url = DIR_SERV . "/producto/actualizar/3DSNG";

$datos["nombre"] = "nombre_aux";
$datos["nombre_corto"] = "nombre_aux";
$datos["descripcion"] = "nombre_aux";
$datos["pvp"] = 2;
$datos["nombre"] = "CAMARA";

$respuesta = consumir_servicios_REST($url, "PUT", $datos);
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
//echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";
echo "<p>Este es el producto actualizado</p>"; 
//Ejercicio 5
echo "---------------------------------------Ejercicio5------------------------------------------------";
$url = DIR_SERV . "/producto/borrar/3DSNG";

$respuesta = consumir_servicios_REST($url, "DELETE");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
//echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";
echo "<p>Borrado correctamente</p>";
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
