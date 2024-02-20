<?php
session_start();
if(isset($_POST["btnBorrarSession"])){
    session_unset();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Estoy recibiendo</h1>
    <h2>Estos son los datos</h2>
    <?php
    if(isset($_SESSION["nombre"])){
    echo $_SESSION["nombre"];
    echo"<br>";
    echo $_SESSION["clave"];
    }
    ?>
    <form action="teoria.php">
        <button type="submit">Volver</button>
    </form>
    
</body>
</html>