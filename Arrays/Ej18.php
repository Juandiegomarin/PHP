<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio18</title>
</head>
<body>

<?php
    $deportes = array("Fútbol", "Baloncesto", "Natación", "Tenis");
    $indice = 0;

    echo "<h3>ARRAY POR CONSOLA</h3><p>";
    for ($i = 0; $i < 300; $i++) {
        if (!empty($deportes[$i])) {
            echo $deportes[$i] . ", ";
        }
    }
    echo "<br/>El contador del array da: " . count($deportes) . "</p>";

    echo "<br/>Primer elemento: " . $deportes[$indice];
    $indice++;
    echo "<br/>Segundo elemento: " . $deportes[$indice];
    $indice++;
    $indice++;
    echo "<br/>Último elemento: " . $deportes[$indice];
    $indice--;
    echo "<br/>Penúltimo elemento: " . $deportes[$indice];
    echo "</p>";

    ?>
    
</body>
</html>