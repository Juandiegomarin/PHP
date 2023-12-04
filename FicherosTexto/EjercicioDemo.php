<?php

function caracterSinRepetir($palabra)
{
    $contador = 0;
    $seguir = false;
    for ($i = 0; $i < strlen($palabra); $i++) {
        $contador = 0;
        for ($j = 0; $j < strlen($palabra); $j++) {


            if ($palabra[$i] == $palabra[$j])
                $contador++;
            if ($contador == 2)
                $seguir = true;
        }
    }

    return $seguir;
}
if (isset($_POST["botonComprobar"])) {


    $palabra = trim($_POST["frase"]);
    $palabra = strtolower($palabra);


    $error_form = caracterSinRepetir($palabra);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo</title>

    <style>
        .error {
            color: red;
        }

        .verde {
            color: green;
        }
    </style>
</head>

<body>

    <form action="EjercicioDemo.php" method="post" enctype="multipart/form-data">

        <p>
            <label for="palabra">Introduzca una palabra</label>
        </p>
        <p>
            <input type="text" name="frase" id="frase">
        <p>
            <?php

            if (isset($_POST["botonComprobar"]) && $error_form)
                echo "<span class='error'>En esta palabra se repiten caracteres</span>";

            ?>

        </p>


        </p>
        <p>
            <button type="submit" name="botonComprobar">Comprobar</button>
        </p>

    </form>

    <?php

    if (isset($_POST["botonComprobar"]) && !$error_form) {

        echo "<span class='verde'>En esta palabra no repiten caracteres</span>";
    }

    ?>


</body>

</html>