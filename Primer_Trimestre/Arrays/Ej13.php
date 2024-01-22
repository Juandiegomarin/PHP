<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 13</title>
</head>
<body>


<?php

$animales=["Lagartija","Araña","Perro","Gato","Ratón"];
$numeros=["12","34","45","52","12"];
$mixto=["Sauce","Pino","Naranjo","Chopo","Perro","34"];

$todos=[];

for ($i=0; $i < count($animales); $i++) { 
    array_push($todos,$animales[$i]);
}

for ($i=0; $i < count($numeros); $i++) { 
    array_push($todos,$numeros[$i]);
}

for ($i=0; $i < count($mixto); $i++) { 
    array_push($todos,$mixto[$i]);
}

$todos=array_reverse($todos);
print_r($todos);

?>
    
</body>
</html>