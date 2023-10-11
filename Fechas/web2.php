<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <form action="web2.php" method="post">
        <h1>Fechas - Formulario</h1>
        <label for="fecha1">Introduce una fecha:</label>
        <select name="fecha1" id="fecha1">
            <?php
            for ($i = 1; $i <= 31; $i++) {
                if ($_POST['fecha1'] == $i) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            ?>
        </select>
        <select name="mes1" id="mes1">
            <?php
            for ($i = 1; $i <= 12; $i++) {
                if ($_POST['mes1'] == $i) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            ?>
        </select>
        <select name="año1" id="año1">
            <?php
            for ($i = 2020; $i >= 1900; $i--) {
                if ($_POST['año1'] == $i) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            ?>
        </select><br>
        <label for="fecha2">Introduce otra fecha:</label>
        <select name="fecha2" id="fecha2">
            <?php
            for ($i = 1; $i <= 31; $i++) {
                if ($_POST['fecha2'] == $i) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            ?>
        </select>
        <select name="mes2" id="mes2">
            <?php
            for ($i = 1; $i <= 12; $i++) {
                if ($_POST['mes2'] == $i) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            ?>
        </select>
        <select name="año2" id="año2">
            <?php
            for ($i = 2020; $i >= 1900; $i--) {
                if ($_POST['año2'] == $i) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            ?>
        </select><br>
        <input type="submit" value="Comprobar" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $fecha1 = $_POST['fecha1'];
        $mes1 = $_POST['mes1'];
        $año1 = $_POST['año1'];
        $fecha2 = $_POST['fecha2'];
        $mes2 = $_POST['mes2'];
        $año2 = $_POST['año2'];

        if (checkdate($mes1, $fecha1, $año1) && checkdate($mes2, $fecha2, $año2)) {
            $fecha1 = strtotime("$año1-$mes1-$fecha1");
            $fecha2 = strtotime("$año2-$mes2-$fecha2");
    
            $diferencia = $fecha2 - $fecha1;
    
            if ($diferencia < 0) {
                $diferencia = $diferencia * -1;
            }
    
            $diferencia = $diferencia / 86400;
            echo "<div class='resultado'><h1>Fechas - Resultado</h1><p>La diferencia entre las dos fechas es de $diferencia dias</p></div>";
        } else {
            echo "<div class='resultado'><h1>Fechas - Resultado</h1><p>Las fechas introducidas no son correctas</p></div>";
        }
    }
    ?>

</body>

</html>