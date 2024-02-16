<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 14</title>
    <style>
        table,tr,td{border:1px solid black;text-align: center;}
        th{text-align: center;}
    </style>
</head>
<body>

<?php

$estadios=["Barcelona"=>"Camp Nou","Real Madrid"=>"santiago Bernabeu","Valencia"=>"Mestalla","Real Sociedad"=>"Anoeta"];

echo"<table>";
echo"<th>Equipos</th>";
foreach ($estadios as $equipo => $estadio) {
    echo"<tr>";
    echo"<td>".$equipo."</td>";
    echo"<td>".$estadio."</td>";
    echo"</tr>";
}


echo"</table>";


?>
    
</body>
</html>