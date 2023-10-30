<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio19</title>
</head>

<body>
    <?php

            $amigos["Madrid"]["Pedro"]["Edad"]="32";
            $amigos["Madrid"]["Pedro"]["Telefono"]="91-9999999";
            $amigos["Madrid"]["Antonio"]["Edad"]="32";
            $amigos["Madrid"]["Antonio"]["Telefono"]="00-9900999";
            $amigos["Madrid"]["Alguien"]["Edad"]="32";
            $amigos["Madrid"]["Alguien"]["Telefono"]="00-9900999";
            $amigos["Barcelona"]["Susana"]["Edad"]="42";
            $amigos["Barcelona"]["Susana"]["Telefono"]="93-0000000";
            $amigos["Toledo"]["Nombre"]["Edad"]="42";
            $amigos["Toledo"]["Nombre"]["Telefono"]="987654321";
            $amigos["Toledo"]["Nombre2"]["Edad"]="43";
            $amigos["Toledo"]["Nombre2"]["Telefono"]="123456789";
            $amigos["Toledo"]["Nombre3"]["Edad"]="42";
            $amigos["Toledo"]["Nombre3"]["Telefono"]="9327382732";



      

    foreach ($amigos as $ciudad => $valores) {
        echo "<p>Amigos en " . $ciudad . "</p>";
        echo "<ol>";
        
        foreach ($valores as $nombre => $datos) {

            echo "<li><trong>Nombre: </strong>" . $nombre . "";
            foreach ($datos as $propiedad => $valor) {
                echo "<strong>" . $propiedad . ": </strong>" . $valor . ". ";
            }
            echo "</li>";
        }
        echo "</ol>";
    }

    ?>



</body>

</html>