<?php

    

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Fechas - Formulario</h1>

    <form action="fecha1.php" method="post" enctype="multipart/form-data">

        <p>
            <label for="fecha1">Introduzca una fecha: (DD/MM/YYYY)</label>
            <input type="text" name="fecha1" id="fecha1">

        </p>
        <p>
            <label for="fecha2">Introduzca una fecha: (DD/MM/YYYY)</label>
            <input type="text" name="fecha2" id="fecha2">

        </p>

        <p>
            <button type="submit" name="botonCalcular">Calcular</button>
        </p>

    </form>
    
</body>
</html>