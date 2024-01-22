<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <style>
        textarea{width: 800px; height: 400px;}
    </style>
</head>

<body>


    <h1>Ejercicio1. Generador de "de claves_cesar.txt"</h1>

    <form action="ejercicio1.php" method="post" enctype="multipart/form-data">

        <button type="submit" name="generar">Generar</button>

    </form>
    <?php
    if (isset($_POST["generar"])) {

        @$f = fopen("claves_cesar.txt", "w");

        if (!$f)
            die("No se ha podido abrir el archivo");
        else {
            define("longitud", ord("Z") - ord("A") + 2);

            $desplazamiento = 1;
            $principio = ord("A");

            for ($i = 0; $i < longitud; $i++) {
                $linea = "";
                for ($j = 0; $j < longitud; $j++) {

                    if ($i == 0 && $j == 0) {
                        $linea .= "Letra/Desplazamiento;";
                    } else if ($i == 0) {
                        $linea.=$j.";";
                    } else {

                        if ($principio == ord("Z")) {
                            $linea .= chr($principio) . ";";
                            $principio = ord("A");
                            $principio--;
                        } else {
                            $linea .= chr($principio) . ";";
                        }
                        $principio++;
                    }
                }
                fputs($f, $linea . PHP_EOL);
                
            } 
            
            echo"<textarea>".file_get_contents("claves_cesar.txt")."</textarea>";
            echo"<p>Fichero generado con éxito</p>";
            fclose($f);
        }

       

    }


    ?>

</body>

</html>