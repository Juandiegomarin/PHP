<?php
session_name("ejercicio01_2023-2024");
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar</title>
    <style>
        .centrado {
            text-align: center;
        }
    </style>
</head>

<body>
    

    <h1 class="centrado">Formulario nombre 1 (Formulario)</h1>
    <?php
        if(isset($_SESSION["nombre"])){
            echo "<p>Su nombre es: <strong>".$_SESSION["nombre"]."</strong></p>";
        }
    ?>
    <form action="Sesiones01_2.php" method="post">
        <p>Escriba su nombre: </p>
        <p>
            <label for="nombre"><strong>Nombre:</strong></label>
            <input type="text" name="nombre" id="nombre">
        </p>
        <p>
            <button type="submit" name="btnSig">Siguiente</button>
            <button type="submit" name="btnBorrar">Borrar</button>
        </p>


    </form>

</body>

</html>