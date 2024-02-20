<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <form action="web3.php" method="post">
    <h1>Fechas - Formulario</h1>
        <label for="fecha1">Introduce una fecha:</label>
        <input type="date" name="fecha1" id="fecha1" required value="<?php
                                                                        if (isset($_POST['fecha1'])) {
                                                                            echo $_POST['fecha1'];
                                                                        } else {
                                                                            echo "";
                                                                        }
                                                                        ?>"><br>
        <label for="fecha2">Introduce otra fecha:</label>
        <input type="date" name="fecha2" id="fecha2" required value="<?php
                                                                        if (isset($_POST['fecha2'])) {
                                                                            echo $_POST['fecha2'];
                                                                        } else {
                                                                            echo "";
                                                                        }
                                                                        ?>"><br>
        <input type="submit" value="Comprobar" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $fecha1 = $_POST['fecha1'];
        $fecha2 = $_POST['fecha2'];

        $fecha1 = strtotime($fecha1);
        $fecha2 = strtotime($fecha2);

        $diferencia = $fecha2 - $fecha1;

        if ($diferencia < 0) {
            $diferencia = $diferencia * -1;
        }

        $diferencia = $diferencia / 86400;
        echo "<div class='resultado'><h1>Fechas - Resultado</h1><p>La diferencia entre las dos fechas es de $diferencia dias</p></div>";
    }
    ?>
</body>

</html>