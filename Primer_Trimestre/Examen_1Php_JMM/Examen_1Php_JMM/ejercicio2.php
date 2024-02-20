<?php

define("LETRASABECEDARIO",  ord("Z") - ord("A"));

function encriptar($texto, $desplazamiento)
{
    $mensajeEncriptado = "";

    for ($i = 0; $i < strlen($texto); $i++) {
        if (ord($texto[$i]) >= ord("A") && ord($texto[$i]) <= ord("Z")) {
            if (ord($texto[$i]) + $desplazamiento > ord("Z")) {

                $mensajeEncriptado .= chr(ord($texto[$i]) + $desplazamiento - LETRASABECEDARIO - 1);
            } else {
                $mensajeEncriptado .= chr(ord($texto[$i]) + $desplazamiento);
            }
        } else {
            $mensajeEncriptado .= $texto[$i];
        }
    }

    return $mensajeEncriptado;
}

function mensajeIncorrecto(string $texto)
{
    $incorrecto = false;
    for ($i = 0; $i < strlen($texto); $i++) {

        if (ord($texto[$i]) != ord(" ") && ord($texto[$i]) != ord(",")  && ord($texto[$i]) != ord(".")) {
            
            if (ord($texto[$i]) < ord("A") || ord($texto[$i]) > ord("Z") && ord($texto[$i]) < ord("a") || ord($texto[$i]) > ord("z")) {
                $incorrecto = true;
                break;
            }
        }
    }

    return $incorrecto;
}

if (isset($_POST['encriptar'])) {

    $errorMensaje = $_POST["mensaje"] == "" || mensajeIncorrecto($_POST['mensaje']);
    $erorrDesplazamiento = $_POST["desplazamiento"] == "" || $_POST["desplazamiento"] < 1 || $_POST["desplazamiento"] > LETRASABECEDARIO;

    $errores = $errorMensaje || $erorrDesplazamiento;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <form action="ejercicio2.php" method="post">

        <p>
            <label for="textoATransformar">Introduce el texto que quiere encriptar:</label> <br>
            <input type="text" name="mensaje" id="textoATransformar" value="<?php if (isset($_POST["encriptar"])) echo  $_POST["mensaje"] ?>">
            <?php
            if (isset($_POST["encriptar"]) && $errorMensaje) {
                if ($_POST["mensaje"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else {
                    echo "<span class='error'>*El mensaje no puede contener 'ñ' tildes ni dieresis*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="numDesplazamiento">De cuanto es el desplazamiento: (1- <?php echo LETRASABECEDARIO ?>)</label> <br>
            <input type="text" name="desplazamiento" id="numDesplazamiento" value="<?php if (isset($_POST["encriptar"])) echo  $_POST["desplazamiento"] ?>">
            <?php
            if (isset($_POST["encriptar"]) && $erorrDesplazamiento) {
                if ($_POST["desplazamiento"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else {
                    echo "<span class='error'>*El desplazamiento debe estar entre 1 y 25*</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="encriptar">Encriptar mensaje</button>
        </p>
    </form>

    <?php
    if (isset($_POST["encriptar"]) && !$errores) {

        $texto = $_POST["mensaje"];
        $desplazamiento = $_POST["desplazamiento"];
        
        echo "El mensaje: <br>" . encriptar($texto, $desplazamiento) . " <br> Pertenece al mensaje: <br> $texto <br> Con desplazamiento $desplazamiento";
    }
    ?>
</body>

</html>