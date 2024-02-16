<?php
session_name("ejercicio03_2023-2024");
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesiones 3</title>
</head>

<body>

    <p>Haga click en los botones para modificar el valor:</p>

    <form action="Sesiones03_2.php" method="post">
        <p>
            <button type="submit" name="cambiar" value="-">-</button>
            <label for="numero"><?php
            if(isset($_SESSION["resultado"]))
             echo $_SESSION["resultado"];
            else
                echo "0";
            
            ?></label>
            <button type="submit" name="cambiar" value="+">+</button>

        </p>
        <button type="submit" name="cambiar">Poner a cero</button>

    </form>

</body>

</html>