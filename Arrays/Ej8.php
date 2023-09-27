<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 8</title>
</head>
<body>


<?php

$arr[]="Pedro";
$arr[]="Ismael";
$arr[]="Sonia";
$arr[]="Clara";
$arr[]="Susana";
$arr[]="Alfonso";
$arr[]="Teresa";



echo"<ul>";
echo"<p>El array contiene ".count($arr)." elementos</p>";

for ($i=0; $i < count($arr) ; $i++) { 

    echo"<li>".$arr[$i]."</li>";
}
echo"</ul>";



?>
    
</body>
</html>