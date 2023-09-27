<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 9</title>
    <style>
        table,tr,td,th  {border:1px solid black}
    </style>
</head>
<body>

<?php

$lenguajes_cliente["LC1"]="JavaScript";
$lenguajes_cliente["LC2"]="Html";
$lenguajes_cliente["LC3"]="Css";

$lenguajes_servidor["LS1"]="Php";
$lenguajes_servidor["LS2"]="Java";
$lenguajes_servidor["LS3"]="MySql";


$lenguajes=$lenguajes_cliente;

foreach ($lenguajes_servidor as $leng => $de) {
    $lenguajes[$leng]=$de;
}

echo"<table>";
echo"<tr><th>Lenguajes</th></tr>";
foreach ($lenguajes as $leng => $de) {
    echo"<tr><td>".$de."</td></tr>";
}


echo"</table>";


?>
    
</body>
</html>