<?php
if (isset($_POST["btnComparar"])) {

    $text1=$_POST["texto1"];
    $text1=trim($text1);
    $error_texto1 = $text1 == "" || strlen($text1) < 3;

    $text2=$_POST["texto2"];
    $text2=trim($text2);
    $error_texto2 = $text2 == "" || strlen($text2) < 3;

    $errores = $error_texto1 || $error_texto2;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio1</title>
    <meta charset="UTF-8" />
    <style>
        .formulario {
            background-color: lightblue;
            border: 2px solid black;
        }

        h2 {
            text-align: center;
        }

        form,
        .respuesta p {
            margin-left: 2em;
        }

        .respuesta {
            background-color: lightgreen;
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <div class="formulario">
        <h2>Ripios-Formulario</h2>
        <form action="Ej1.php" method="post" enctype="multipart/form-data">

            <p>Dime dos palabras y te diré si riman o no</p>
            <p><label for="texto1">Primera palabra: </label>
                <input type="text" name="texto1" id="texto1" value="<?php if (isset($_POST["btnComparar"])) echo $text1; ?>" />
                <?php
                if (isset($_POST["btnComparar"]) && $error_texto1) {

                    if ($_POST["texto1"] == "") {

                        echo "Campo vacio";
                    } else {

                        echo "La palabra debe de tener al menos tres letras";
                    }
                }
                ?>

</p>
            <p><label for="texto2">Segunda palabras: </label>
                <input type="text" name="texto2" id="texto2" value="<?php if (isset($_POST["btnComparar"])) echo $text2; ?>" />
                <?php
                if (isset($_POST["btnComparar"]) && $error_texto2) {

                    if ($_POST["texto2"] == "") {

                        echo "Campo vacio";
                    } else {

                        echo "La palabra debe de tener al menos tres letras";
                    }
                }
                ?>
            </p>
            <p><button type="submit" name="btnComparar">Comparar</button></p>

        </form> 
    </div>
    <?php
    if (isset($_POST["btnComparar"]) && !$errores) {

        $long1 = strlen($text1);
        $long2 = strlen($text2);

        $texto1 = strtolower($text1);
        

        $texto2 = strtolower($text2);
        

        $riman = "no riman";

        if ($text1[$long1 - 1] == $text2[$long2 - 1]) {

            if ($text1[$long1 - 2] == $text2[$long2 - 2]) {

                if ($text1[$long1 - 3] == $text2[$long2 - 3]) {

                    $riman = "riman";
                } else {

                    $riman = "riman un poco";
                }
            }
        }
    ?>
        <div class="respuesta">
            <h2>Ripios-Respuesta</h2>
            <p>Las palabras <strong><?php echo $text1; ?></strong> y <strong><?php echo $text2; ?></strong> <?php echo $riman; ?> </p>
        </div>

    <?php
    }
    ?>
</body>

</html>