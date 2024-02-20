<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>
<body>

    <?php

    $arr[]="Madrid";
    $arr[]="Barcelona";
    $arr[]="Londres";
    $arr[]="New York";
    $arr[]="Los Ángeles";
    $arr[]="Chicago";


    for ($i=0; $i < count($arr) ; $i++) { 
        echo"<p>La ciudad con el índice ".$i." contiene la ciudad ".$arr[$i]."</p>";
    }




    ?>
    
</body>
</html>