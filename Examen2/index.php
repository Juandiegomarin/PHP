<?php

function error_page($title, $body)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' . $body . '</body></html>';
    return $html;
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: lightgrey;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 60%;
        }

        .enlace {
            text-decoration: underline;
            cursor: pointer;
            color: blue;
            border: none;
            background: none;
        }
    </style>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>

    <?php
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No se ha podido conectar a la base de datos:" . $e->getMessage() . "</p></body></html>");
    }

    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
    }


    echo "<form method='post' action='index.php'>
            
            <label>Horarios del Profesor:</label>

            <select name='profe'>";

    while ($fila = mysqli_fetch_assoc($resultado)) {

        if ((isset($_POST["verNotas"]) && ($_POST["profe"] == $fila["id_usuario"])) || (isset($_POST["btnEditar"]) && $_POST["btnEditar"]==$fila["id_usuario"])) {
            echo "<option value='" . $fila["id_usuario"] . "' selected>" . $fila["nombre"] . "</option>";
            $nombre_profe = $fila["nombre"];
        } else {
            echo "<option value='" . $fila["id_usuario"] . "'>" . $fila["nombre"] . "</option>";
        }
    }


    echo "</select>
            
            <button type='submit' name='verNotas'>Ver Notas</button>
            </form>";

    if (isset($_POST["verNotas"]) || isset($_POST["btnEditar"])) {

        if(isset($_POST["btnEditar"])){

            try {
                $consulta = "select nombre from usuarios where id_usuario=" . $_POST["btnEditar"] . "";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
            }
         $datos=mysqli_fetch_assoc($resultado);
         $nombre_profe=$datos["nombre"];
         $id_profe=$_POST["btnEditar"];   

        }
        if(isset($_POST["verNotas"])){
            $id_profe=$_POST["profe"];
        }
        echo "<h3>Horario del profesor:" . $nombre_profe . "</h3>";

        echo "<table>";

        echo "<tr> <th></th> <th>Lunes</th> <th>Martes</th> <th>Miércoles</th> <th>Jueves</th> <th>Viernes</th> </tr>";
        echo "<tr> <th>8:15-9:15</th>";

        for ($i = 1; $i <= 5; $i++) {


            try {
                $consulta = "select grupo from horario_lectivo where usuario=" . $id_profe . " and hora=1 and dia=" . $i . "";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
            }

            if (mysqli_num_rows($resultado) > 0) {
                $grupo = mysqli_fetch_assoc($resultado);

                $id_grupo = $grupo["grupo"];

                try {
                    $consulta = "select nombre from grupos where id_grupo=" . $id_grupo . "";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
                }

                $nombre = mysqli_fetch_assoc($resultado);

                echo "<td><p>" . $nombre["nombre"] . "</p><form method='post' action='index.php'><input type='hidden' name='hora' value='1'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $i . "' name='btnEditar''>Editar</button></form></td>";;
            } else {


                echo "<td><form method='post' action='index.php'><input type='hidden' name='hora' value='1'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $id_profe . "' name='btnEditar''>Editar</button></form></td>";
            }
        }
        echo "</tr>";
        echo "<tr> <th>9:15-10:15</th>";
        for ($i = 1; $i <= 5; $i++) {


            try {
                $consulta = "select grupo from horario_lectivo where usuario=" . $id_profe . " and hora=2 and dia=" . $i . "";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
            }

            if (mysqli_num_rows($resultado) > 0) {
                $grupo = mysqli_fetch_assoc($resultado);

                $id_grupo = $grupo["grupo"];

                try {
                    $consulta = "select nombre from grupos where id_grupo=" . $id_grupo . "";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
                }

                $nombre = mysqli_fetch_assoc($resultado);
                echo "<td><p>" . $nombre["nombre"] . "</p><form method='post' action='index.php'><input type='hidden' name='hora' value='2'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $i . "' name='btnEditar''>Editar</button></form></td>";;
            } else {


                echo "<td><form method='post' action='index.php'><input type='hidden' name='hora' value='2'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $id_profe . "' name='btnEditar''>Editar</button></form></td>";
            }
        }
        echo "</tr>";
        echo "<tr> <th>10:15-11:15</th>";
        for ($i = 1; $i <= 5; $i++) {


            try {
                $consulta = "select grupo from horario_lectivo where usuario=" . $id_profe . " and hora=3 and dia=" . $i . "";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
            }

            if (mysqli_num_rows($resultado) > 0) {
                $grupo = mysqli_fetch_assoc($resultado);

                $id_grupo = $grupo["grupo"];

                try {
                    $consulta = "select nombre from grupos where id_grupo=" . $id_grupo . "";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
                }

                $nombre = mysqli_fetch_assoc($resultado);

                echo "<td><p>" . $nombre["nombre"] . "</p><form method='post' action='index.php'><input type='hidden' name='hora' value='3'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $i . "' name='btnEditar''>Editar</button></form></td>";;
            } else {


                echo "<td><form method='post' action='index.php'><input type='hidden' name='hora' value='3'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $id_profe . "' name='btnEditar''>Editar</button></form></td>";
            }
        }
        echo "</tr>";
        echo "<tr> <th>11:15-11:45</th> <td colspan=5 >Recreo</td></tr>";
        echo "<tr> <th>11:45-12:45</th>";
        for ($i = 1; $i <= 5; $i++) {


            try {
                $consulta = "select grupo from horario_lectivo where usuario=" . $id_profe . " and hora=5 and dia=" . $i . "";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
            }

            if (mysqli_num_rows($resultado) > 0) {
                $grupo = mysqli_fetch_assoc($resultado);

                $id_grupo = $grupo["grupo"];

                try {
                    $consulta = "select nombre from grupos where id_grupo=" . $id_grupo . "";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
                }

                $nombre = mysqli_fetch_assoc($resultado);

                echo "<td><p>" . $nombre["nombre"] . "</p><form method='post' action='index.php'><input type='hidden' name='hora' value='4'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $i . "' name='btnEditar''>Editar</button></form></td>";;
            } else {


                echo "<td><form method='post' action='index.php'><input type='hidden' name='hora' value='4'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $id_profe . "' name='btnEditar''>Editar</button></form></td>";
            }
        }
        echo " </tr>";
        echo "<tr> <th>12:45-13:45</th>";
        for ($i = 1; $i <= 5; $i++) {


            try {
                $consulta = "select grupo from horario_lectivo where usuario=" . $id_profe . " and hora=6 and dia=" . $i . "";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
            }

            if (mysqli_num_rows($resultado) > 0) {
                $grupo = mysqli_fetch_assoc($resultado);

                $id_grupo = $grupo["grupo"];

                try {
                    $consulta = "select nombre from grupos where id_grupo=" . $id_grupo . "";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
                }

                $nombre = mysqli_fetch_assoc($resultado);

                echo "<td><p>" . $nombre["nombre"] . "</p><form method='post' action='index.php'><input type='hidden' name='hora' value='5'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $i . "' name='btnEditar''>Editar</button></form></td>";;
            } else {


                echo "<td><form method='post' action='index.php'><input type='hidden' name='hora' value='5'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $id_profe . "' name='btnEditar''>Editar</button></form></td>";
            }
        }
        echo "</tr>";
        echo "<tr> <th>13:45-14:45</th>";
        for ($i = 1; $i <= 5; $i++) {


            try {
                $consulta = "select grupo from horario_lectivo where usuario=" . $id_profe . " and hora=7 and dia=" . $i . "";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
            }

            if (mysqli_num_rows($resultado) > 0) {
                $grupo = mysqli_fetch_assoc($resultado);

                $id_grupo = $grupo["grupo"];

                try {
                    $consulta = "select nombre from grupos where id_grupo=" . $id_grupo . "";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
                }

                $nombre = mysqli_fetch_assoc($resultado);

                echo "<td><p>" . $nombre["nombre"] . "</p><form method='post' action='index.php'><input type='hidden' name='hora' value='6'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $i . "' name='btnEditar''>Editar</button></form></td>";;
            } else {


                echo "<td><form method='post' action='index.php'><input type='hidden' name='hora' value='6'/><input type='hidden' name='dia' value='".$i."'/><button class='enlace' type='submit' value='" . $id_profe . "' name='btnEditar''>Editar</button></form></td>";
            }
        }
        echo " </tr>";


        echo "</table>";

        if(isset($_POST["btnEditar"])){

            $horas[1]="8:15-9:15";
            $horas[2]="9:15-10:15";
            $horas[3]="10:15-11:15";
            $horas[4]="11:15-12:45";
            $horas[5]="12:15-13:45";
            $horas[6]="13:15-14:45";

            $dia[1]="Lunes";
            $dia[2]="Martes";
            $dia[3]="Miercoles";
            $dia[4]="Jueves";
            $dia[5]="Viernes";

            echo "<h2>Editando la ".$_POST["hora"]."º hora (".$horas[$_POST["hora"]].") del ".$dia[$_POST["dia"]]."</h2>";
            echo "<table><tr><th>Grupo</th><th>Acción</th></tr>";
            echo "<tr>";

            echo"</tr>";

            try {
                $consulta = "select grupo from horario_lectivo where usuario=" . $_POST["btnEditar"] . " and hora=".$_POST["hora"]." and dia=" . $_POST["dia"] . "";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
            }
            
            $nombre = mysqli_fetch_assoc($resultado);
            echo"<td>".$nombre["nombre"] ."</td>";
            echo"<td><form method='post' action='index.php'><button class='enlace' type='submit' value='" . $id_profe . "' name='btnBorrar''>Quitar</button></form></td>";
            "</table>";
        }
    }
    ?>

</body>

</html>