<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<?php

$arr["MD"]="Madrid";
$arr["BC"]="Barcelona";
$arr["LD"]="Londres";
$arr["NY"]="New York";
$arr["LA"]="Los Ángeles";
$arr["CH"]="Chicago";


foreach ($arr as $indice => $ciudad) {
    echo"<p>El indice del array que contiene la ciudad ".$ciudad." es: ".$indice."</p>";
}




?>


    
</body>
</html>