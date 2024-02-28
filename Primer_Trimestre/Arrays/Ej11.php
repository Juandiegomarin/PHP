<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 11</title>
</head>
<body>


<?php

$animales=["Lagartija","Araña","Perro","Gato","Ratón"];
$numeros=["12","34","45","52","12"];
$mixto=["Sauce","Pino","Naranjo","Chopo","Perro","34"];

$todos=array_merge($animales,$numeros,$mixto);

print_r($todos);

?>
    
</body>
</html>