<?php
session_start();    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Teoría de sesiones</h1>
    <?php
    $_SESSION["nombre"]="Juan Diego Marín";
    $_SESSION["clave"]=md5("12345");

    
    ?>
    <p><a href="recibido.php">Ver Datos</a></p>
    <form action="recibido.php" method="post">
        <button type="submit" name="btnBorrarSession">Borrar datos Sesión</button>
    </form>
</body>
</html>