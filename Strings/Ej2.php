<?php
if (isset($_POST["btnComprobar"])) {

    $texto1 = $_POST["texto1"];
    $texto1=trim($texto1);
    $errores = $texto1 == "" || strlen($texto1) < 3;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio2</title>
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
        <form action="Ej2.php" method="post" enctype="multipart/form-data">

            <p>Dime una palabra o un número y te dire si es palindromo o capicua</p>
            <p><label for="texto1">Primera palabra: </label>
                <input type="text" name="texto1" id="texto1" value="<?php if (isset($_POST["btnComprobar"])) echo $_POST["texto1"]; ?>" />
                <?php
                if (isset($_POST["btnComprobar"]) && $errores) {

                    if ($_POST["texto1"] == "") {

                        echo "Campo vacio";
                    } else {

                        echo "La palabra debe de tener al menos tres letras";
                    }
                }
                ?>

            </p>

            <p><button type="submit" name="btnComprobar">Comprobar</button></p>

        </form>
    </div>
    <?php
    if (isset($_POST["btnComprobar"]) && !$errores) {

        $long1 = strlen($texto1);
        $seguir = true;
        $respuesta="";

        $texto1_m = strtoupper($texto1);

        if (is_numeric($texto1)) {


            for ($i = 0; $i < $long1; $i++) {

                if ($texto1[$i] != $texto1[$long1 - 1 - $i]) {

                    $seguir = false;
                }

                if ($i >= $long1 - 1 - $i) {

                    break;
                }
            }

            if($seguir){

               $respuesta = $texto1." es capicua";

            }
            else{

                $respuesta = $texto1." no es capicua";

            }
        }
        else{

            for ($i = 0; $i < $long1; $i++) {

                if ($texto1[$i] != $texto1[$long1 - 1 - $i]) {

                    $seguir = false;
                }

                if ($i >= $long1 - 1 - $i) {

                    break;
                }
            }

            if($seguir){

               $respuesta = $texto1." es palindromo";

            }
            else{

                $respuesta = $texto1." no es palindromo";

            }




        }









    ?>
        <div class="respuesta">
            <h2>Ripios-Respuesta</h2>
            <p> <?php echo $respuesta; ?> </p>
        </div>

    <?php
    }
    ?>
</body>

</html>