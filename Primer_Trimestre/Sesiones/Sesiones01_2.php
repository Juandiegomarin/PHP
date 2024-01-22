<?php
session_name("ejercicio01_2023-2024");
session_start();
if(isset($_POST["nombre"])){
    if($_POST["nombre"] == ""){
        unset($_SESSION["nombre"]);
    }else
     $_SESSION["nombre"] = $_POST["nombre"];
}
if(isset($_POST["btnBorrar"])){
    session_destroy();
    header("Location:Sesiones01_1.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibido</title>
    <style>
        .centrado {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 class="centrado">Formulario nombre 1 (Formulario)</h1>
    <?php
    if (isset($_SESSION["nombre"])) {
        echo "<p>Su nombre es: <strong>" . $_SESSION["nombre"] . "</strong></p>";
       
    } else {
        echo "<p>En primera página no has tecleado nada</p>";
    }

    ?>
    <p><a href="Sesiones01_1.php">Volver a la primera página</a></p>
</body>

</html>