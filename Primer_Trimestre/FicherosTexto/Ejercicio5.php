<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>

    <style>
        table {
            width: 90%;
            margin: 0 auto;
            text-align: center;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>

    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");

    if (!$fd)
        die("<p>No se ha podido abrir la fuente de los datos</p>");
    else {

        echo "<table>";
        $linea = "";
        $cuento_lineas = 0;
        while ($linea = fgets($fd)) {


            $linea = explode("\t", $linea);

            echo "<tr>";
            if ($cuento_lineas == 0)
                echo "<th>" . substr($linea[0], -4) . "</th>";
            else {
                $array = explode(",", $linea[0]);
                echo "<th>".end($array)."</th>";
            }

            for ($i = 1; $i < count($linea); $i++) {
                if ($cuento_lineas == 0) {
                    echo "<th>" . $linea[$i] . "</th>";
                } else if ($cuento_lineas > 0) {
                    echo "<td>" . $linea[$i] . "</td>";
                }
            }
            $cuento_lineas++;
            echo "</tr>";
        }



        echo "</table>";
    }

    fclose($fd);

    ?>

</body>

</html>