<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


    <h1>Notas de los alumnos</h1>
<?php

    $notas["Antonio"]["DWESE"]=5;
    $notas["Antonio"]["DWEC"]=7;
    $notas["Luis"]["DWESE"]=9;
    $notas["Luis"]["DWEC"]=7;
    $notas["Ana"]["DWESE"]=8;
    $notas["Ana"]["DWEC"]=9;
    $notas["Eloy"]["DWESE"]=5;
    $notas["Eloy"]["DWEC"]=6;

    

    foreach ($notas as $nombre => $asignaturas) {

        echo "<p>".$nombre;
        echo "<ul>";
        foreach ($asignaturas as $asignatura => $nota) {

            echo "<li>La nota en ".$asignatura." ha sido: ".$nota."</li>";
            
            
        }
        echo "</ul>";

        "</p>";
        
    }





?>
    
</body>
</html>