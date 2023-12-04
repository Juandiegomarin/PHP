<?php

if (isset($_POST["codificar"])) {


    $max = ord("Z") - ord("A") + 1;
    $error_texto = $_POST["texto"] == "";
    $error_des = !is_numeric($_POST["des"]) || $_POST["des"] < 1 || $_POST["des"] > $max;
    $error_file = $_FILES["examinar"]["name"] = "" || $_FILES["examinar"]["error"] || $_FILES["examinar"]["type"] != "text/plain" || $_FILES["examinar"]["size"] > 1250 * 3600;

    $error_form = $error_texto || $error_des || $error_file;
}
 

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <h1>Codifica una frase</h1>


    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">

        <p>
            <label for="texto">Introduzaca un texto:</label>
            <input type="text" name="texto" id="texto" value="<?php
                                                                if (isset($_POST["texto"])) echo $_POST["texto"];
                                                                ?>">

            <?php
            if (isset($_POST["texto"]) && $error_texto) {

                echo "<span class='error'>El campo no puede estar vacío</span>";
            }
            ?>

        </p>
        <p>
            <label for="desp">Desplazamiento:</label>
            <input type="text" name="des" id="des" value="<?php
                                                            if (isset($_POST["des"])) echo $_POST["des"];
                                                            ?>">
            <?php
            if (isset($_POST["des"]) && $error_des) {

                if (!is_numeric($_POST["des"]) && $_POST["des"] != "")
                    echo "<span class='error'>El campo no es un número</span>";
                else if ($_POST["des"] == "")
                    echo "<span class='error'>El campo no puede estar vacío</span>";
                else
                    echo "<span class='error'>Número no válido, debe estar entre 1 y 26</span>";
            }
            ?>


        </p>
        <p>
            <label for="cod">Seleccione el archivo de claves(.txt y menor de 1,25MB)</label>
            <input type="file" name="examinar" id="cod" value="Examinar...">

            <?php
            if (isset($_POST["examinar"]) && $error_file) {

                if ($_FILES["examinar"]["error"])
                    echo "<span class='error'>Error al subir el archivo</span>";
                else if ($_FILES["examinar"]["size"] > 1000 * 3600)
                    echo "<span class='error'>El archivo supera los 1,25MB</span>";
                else
                    echo "<span class='error'>El archivo no es te tipo txt</span>";
            }
            ?>

        </p>
        <p>
            <button type="submit" name="codificar">Codificar</button>
        </p>

    </form>

    <?php
    if (isset($_POST["codificar"]) && !$error_form) {

        @$f = fopen("claves_cesar.txt", "r");

        $longitud_linea = (ord("Z") - ord("A")) + 2;


        $texto = $_POST["texto"];
        $desplazamiento = $_POST["des"];


        $longitud = 0;

        while (isset($texto[$longitud]))
            $longitud++;



        $palabras_descodificada = "";


        for ($i = 0; $i < $longitud; $i++) {

            if (ord($texto[$i]) >= ord("A") && ord($texto[$i]) <= ord("Z")) {

                fseek($f,0);
                $indice = (ord("Z") - ord("A")) - (ord("Z") - ord($texto[$i])) + 1;

                for ($j = 0; $j < $longitud_linea; $j++) {

                    $linea = fgets($f);
                    
                    if ($j == $indice) {
                        $arr=explode(";",$linea);
                        
                        for ($h = 0; $h < $longitud_linea; $h++) {

                            if ($h == $desplazamiento) {
                                $palabras_descodificada .= $arr[$h];
                                
                                break;
                            }
                        }
                    }
                }
            } else {

                $palabras_descodificada .= $texto[$i];
            }
        }

        fclose($f);

        echo "<h1>Resultado</h1>";
        echo "<p>El texto codificado sería:</p>";
        echo "<p>" . $palabras_descodificada . "</p>";
    }
    ?>




</body>

</html>