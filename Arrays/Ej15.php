<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 15</title>
</head>
<body>


<?php

    $numeros=array(3,2,8,123,5,1);

    $arr["N1"]=$numeros[0];
    $arr["N2"]=$numeros[1];
    $arr["N3"]=$numeros[2];
    $arr["N4"]=$numeros[3];
    $arr["N5"]=$numeros[4];
    $arr["N6"]=$numeros[5];
    
    
    

    natsort($arr);

    print_r($arr);

    


?>
    
</body>
</html>