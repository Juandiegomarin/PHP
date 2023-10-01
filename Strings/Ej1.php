<?php
if (isset($_POST["btnComparar"])) {

    $error_texto1 = $_POST["texto1"] == "" || strlen($_POST["texto1"]) < 3;
    $error_texto2 = $_POST["texto2"] == "" || strlen($_POST["texto2"]) < 3;

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
                <input type="text" name="texto1" id="texto1" value="<?php if (isset($_POST["btnComparar"])) echo $_POST["texto1"]; ?>" />
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
                <input type="text" name="texto2" id="texto2" value="<?php if (isset($_POST["btnComparar"])) echo $_POST["texto2"]; ?>" />
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

        $long1 = strlen($_POST["texto1"]);
        $long2 = strlen($_POST["texto2"]);

        $texto1 = strtolower($_POST["texto1"]);
        trim($texto1);

        $texto2 = strtolower($_POST["texto2"]);
        trim($texto2);

        $riman = "no riman";

        if ($texto1[$long1 - 1] == $texto2[$long2 - 1]) {

            if ($texto1[$long1 - 2] == $texto2[$long2 - 2]) {

                if ($texto1[$long1 - 3] == $texto2[$long2 - 3]) {

                    $riman = "riman";
                } else {

                    $riman = "riman un poco";
                }
            }
        }
    ?>
        <div class="respuesta">
            <h2>Ripios-Respuesta</h2>
            <p>Las palabras <strong><?php echo $_POST["texto1"]; ?></strong> y <strong><?php echo $_POST["texto2"]; ?></strong> <?php echo $riman; ?> </p>
        </div>

    <?php
    }
    ?>
</body>

</html>