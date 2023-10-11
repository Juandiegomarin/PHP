<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <form action="web1.php" method="post">
        <h1>Fechas - Formulario</h1>
        <label for="fecha1">Introduce una fecha(DD/MM/YYYY):</label>
        <input type="text" name="fecha1" id="fecha1" required value="<?php
                                                                        if (isset($_POST['fecha1'])) {
                                                                            echo $_POST['fecha1'];
                                                                        } else {
                                                                            echo "";
                                                                        }
                                                                        ?>"><br>
        <label for="fecha2">Introduce otra fecha(DD/MM/YYYY):</label>
        <input type="text" name="fecha2" id="fecha2" required value="<?php
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
        if (strlen($fecha1) == 10 && strlen($fecha2) == 10) {
            $fecha1 = explode("/", $fecha1);
            $fecha2 = explode("/", $fecha2);
            if (checkdate($fecha1[1], $fecha1[0], $fecha1[2]) && checkdate($fecha2[1], $fecha2[0], $fecha2[2])) {
                $fecha1 = strtotime($fecha1[2] . "-" . $fecha1[1] . "-" . $fecha1[0]);
                $fecha2 = strtotime($fecha2[2] . "-" . $fecha2[1] . "-" . $fecha2[0]);
                $diferencia = $fecha2 - $fecha1;
                if ($diferencia < 0) {
                    $diferencia = $diferencia * -1;
                }
                $diferencia = $diferencia / 86400;
                echo "<div class='resultado'><h1>Fechas - Resultado</h1><p>La diferencia entre las dos fechas es de $diferencia dias</p></div>";
            } else {
                echo "<div class='resultado'><h1>Fechas - Resultado</h1><p>Alguna de las fechas introducidas no es correcta</p></div>";
            }
        } else {
            echo "<div class='resultado'><h1>Fechas - Resultado</h1><p>Alguna de las fechas introducidas no es correcta</p></div>";
        }
    }
    ?>
</body>

</html>