<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

$pelisMeses["enero"]=9;
$pelisMeses["febrero"]=12;
$pelisMeses["marzo"]=0;
$pelisMeses["abril"]=7;

foreach ($pelisMeses as $mes => $numPelis) {
    if ($numPelis>0) {
        echo"<p>En el mes ".$mes." se han visto ".$numPelis." peliculas</p>";
    }
}



?>
    
</body>
</html>