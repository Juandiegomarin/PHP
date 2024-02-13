<?php
session_name("Exam_horarios_prof");
session_start();
define("DIR_SERV", "http://localhost/Proyectos/Examen_Repaso_Servicios/servicios_rest");
define("MINUTOS", 100);
function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title, $body)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' . $body . '</body></html>';
    return $html;
}
if (isset($_POST["btnSalir"])) {

    $url = DIR_SERV . "/salir";
    session_destroy();
    header("Location:#");
    exit;
}

if (isset($_POST["btnLogin"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {

        $url = DIR_SERV . "/login";

        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $url . "</p>"));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $obj->error . "</p>"));
        }
        if (isset($obj->mensaje)) {
            $error_usuario = true;
            session_destroy();
            die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $obj->mensaje . "</p>"));
        }

        $_SESSION["usuario"] = $obj->usuario->usuario;
        $_SESSION["clave"] = $obj->usuario->clave;
        $_SESSION["token"] = $obj->token;
        $_SESSION["ultima_accion"] = time();

        header("Location:#");
        exit;
    }
}
if (isset($_SESSION["usuario"])) {
    // Seguridad

    $url = DIR_SERV . "/logeado";
    $datos["token"] = $_SESSION["token"];
    $respuesta = consumir_servicios_REST($url, "POST", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $url . "</p>"));
    }
    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $obj->error . "</p>"));
    }
    if (isset($obj->mensaje)) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ya no se encuentra en la base de datos";
        header("Location:#");
        exit;
    }
    if (isset($obj->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo de sesion de la api ha caducado";
        header("Location:#");
        exit;
    }

    $datos_usuario_logeado = $obj->usuario;

    if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo de sesion ha caducado";
        header("Location:#");
        exit;
    }

    if ($datos_usuario_logeado->tipo == "admin") {

        if (isset($_POST["btnSeleccionar"]) || isset($_POST["btnEditar"])) {

            if (isset($_POST["btnSeleccionar"])) {
                $id_profesor_seleccionado = $_POST["profesores"];
            } else if (isset($_POST["btnEditar"])) {
                $id_profesor_seleccionado = $_POST["btnEditar"];
            } else {
                $id_profesor_seleccionado = 0;
            }
        }
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Vista admin</title>
            <style>
                .enLinea {
                    display: inline;
                }

                .enlace {
                    background: none;
                    border: none;
                    cursor: pointer;
                    color: blue;
                    text-decoration: underline;
                }

                th {
                    background-color: lightgrey;
                }

                table {
                    width: 60%;
                    text-align: center;
                }

                table,
                td,
                th,
                tr {
                    border: 1px solid black;
                    border-collapse: collapse;
                }
            </style>
        </head>

        <body>

            <div>
                Bienvenido: <strong><?php echo $datos_usuario_logeado->usuario ?></strong>
                <form action="#" method="post" class="enLinea">
                    <button type="submit" name="btnSalir" class="enlace">Salir</button>
                </form>
            </div>

            <h1>Examen 2 PHP</h1>

            <h2>Horario de los profesores</h2>
            <form action="#" method="post">
                <p>
                    <select name="profesores" id="prof">
                        <?php
                        $url = DIR_SERV . "/obtenerProfesores/" . urlencode($_SESSION["token"]);
                        $respuesta = consumir_servicios_REST($url, "GET");
                        $obj = json_decode($respuesta);

                        if (!$obj) {
                            session_destroy();
                            die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $url . "</p>"));
                        }
                        if (isset($obj->error)) {
                            session_destroy();
                            die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $obj->error . "</p>"));
                        }

                        if (isset($obj->no_auth)) {
                            session_unset();
                            $_SESSION["seguridad"] = "Tiempo de sesion de la api ha caducado";
                            header("Location:#");
                            exit;
                        }

                        foreach ($obj->profesores as $profe) {

                            if ($id_profesor_seleccionado == $profe->id_usuario) {
                                echo "<option value='" . $profe->id_usuario . "' selected>" . $profe->usuario . "</option>";
                            } else {
                                echo "<option value='" . $profe->id_usuario . "'>" . $profe->usuario . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <button type="submit" name="btnSeleccionar">Ver Horario</button>
                </p>
            </form>



            <?php
            if (isset($_POST["btnSeleccionar"]) || isset($_POST["btnEditar"])) {
                $url = DIR_SERV . "/obtenerProfesor/" . $id_profesor_seleccionado . "/" . $_SESSION["token"];
                $respuesta = consumir_servicios_REST($url, "GET");
                $obj = json_decode($respuesta);

                if (!$obj) {
                    session_destroy();
                    die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $url . "</p>"));
                }
                if (isset($obj->error)) {
                    session_destroy();
                    die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $obj->error . "</p>"));
                }
                if (isset($obj->mensaje)) {
                    session_destroy();
                    die(error_page("Error servicio", "<p>Error consumiendo servicios rest" . $obj->mensaje . "</p>"));
                }
                if (isset($obj->no_auth)) {
                    session_unset();
                    $_SESSION["seguridad"] = "Tiempo de sesion de la api ha caducado";
                    header("Location:#");
                    exit;
                }

                echo "<h2>Horario del profesor: " . $obj->profesor->nombre . "</h2>";

                echo "<table>";
                echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";
                $horas[1] = "8:15 - 9:15";
                $horas[] = "9:15 - 10:15";
                $horas[] = "10:15 - 11:15";
                $horas[] = "11:15 - 11:45";
                $horas[] = "11:45 - 12:45";
                $horas[] = "12:45 - 13:45";
                $horas[] = "13:45 - 14:45";


                for ($i = 1; $i < 8; $i++) {
                    echo "<tr><th>" . $horas[$i] . "</th>";

                    if ($i == 4) {
                        echo "<th colspan='5'>RECREO</th>";
                    } else {
                        for ($j = 1; $j <= 5; $j++) {
                            $url = DIR_SERV . "/obtenerGrupo";
                            $datos["id_usuario"] = $id_profesor_seleccionado;
                            $datos["dia"] = $j;
                            $datos["hora"] = $i;
                            $datos["token"] = $_SESSION["token"];

                            $respuesta = consumir_servicios_REST($url, "POST", $datos);
                            $obj = json_decode($respuesta);

                            if (!$obj) {
                                session_destroy();
                                die("<h1>Error servicio</h1><p>Error consumiendo servicios" . $url . "</p></body></html>");
                            }
                            if (isset($obj->error)) {
                                session_destroy();
                                die("<h1>Error servicio</h1><p>Error consumiendo servicios rest " . $obj->error . "</p></body></html>");
                            }
                            if (isset($obj->no_auth)) {
                                session_unset();
                                $_SESSION["seguridad"] = "Tiempo de sesion de la api ha caducado";
                                header("Location:#");
                                exit;
                            }
                            if (isset($obj->mensaje)) {
                                echo "<td><form action='#' method='post'><button class='enlace' name='btnEditar' value='" . $id_profesor_seleccionado . "'>Editar</button><input type='hidden' name='dia' value='" . $j . "'/> <input type='hidden' name='hora' value='" . $i . "'/></form></td>";
                            } else {
                                $url = DIR_SERV . "/obtenerNombreGrupo/" . $obj->grupo->grupo;
                                $respuesta = consumir_servicios_REST($url, "GET", $datos);
                                $obj = json_decode($respuesta);

                                if (!$obj) {
                                    session_destroy();
                                    die("<h1>Error servicio</h1><p>Error consumiendo servicios" . $url . "</p></body></html>");
                                }
                                if (isset($obj->error)) {
                                    session_destroy();
                                    die("<h1>Error servicio</h1><p>Error consumiendo servicios rest " . $obj->error . "</p></body></html>");
                                }
                                if (isset($obj->no_auth)) {
                                    session_destroy();
                                    $_SESSION["seguridad"] = "Tiempo de sesion de la api ha caducado";
                                    header("Location:#");
                                    exit;
                                }
                                if (isset($obj->mensaje)) {
                                    session_destroy();
                                    die("<h1>Error servicio</h1><p>Error consumiendo servicios rest " . $obj->mensaje . "</p></body></html>");
                                }

                                echo "<td>" . $obj->nombre->nombre . "<br><form action='#' method='post'><button class='enlace' name='btnEditar' value='" . $id_profesor_seleccionado . "'>Editar</button> <input type='hidden' name='dia' value='" . $j . "'/> <input type='hidden' name='hora' value='" . $i . "'/></form></td>";
                            }
                        }
                    }
                    echo "</tr>";
                }

                echo "</table>";

                if (isset($_POST["btnEditar"])) {
                    $horas[1] = "8:15 - 9:15";
                    $horas[] = "9:15 - 10:15";
                    $horas[] = "10:15 - 11:15";
                    $horas[] = "11:45 - 12:45";
                    $horas[] = "12:45 - 13:45";
                    $horas[] = "13:45 - 14:45";

                    $dias[1] = "Lunes";
                    $dias[] = "Martes";
                    $dias[] = "Miercoles";
                    $dias[] = "Jueves";
                    $dias[] = "Viernes";


                    $h = $_POST["hora"];
                    if ($h > 3) {
                        $h -= 1;
                    }
                    echo "<h1>Editando la " . $h . " hora ( " . $horas[$h] . " ) del " . $dias[$_POST["dia"]] . "</h1>";
                    echo "<table>";
                    echo "<tr><th>Grupo</th><th>Acción</th></tr>";


                    echo "</table>";
                }
            }
            ?>
        </body>

        </html>
    <?php
    } else {
    ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Vista normal</title>
            <style>
                .enLinea {
                    display: inline;
                }

                .enlace {
                    background: none;
                    border: none;
                    cursor: pointer;
                    color: blue;
                    text-decoration: underline;
                }

                th {
                    background-color: lightgrey;
                }

                table {
                    width: 60%;
                    text-align: center;
                }

                table,
                td,
                th,
                tr {
                    border: 1px solid black;
                    border-collapse: collapse;
                }
            </style>
        </head>

        <body>

            <div>
                Bienvenido: <strong><?php echo $datos_usuario_logeado->usuario ?></strong>
                <form action="#" method="post" class="enLinea">
                    <button type="submit" name="btnSalir" class="enlace">Salir</button>
                </form>

            </div>

            <?php
            echo "<h2>Horario del profesor con id: " . $datos_usuario_logeado->id_usuario . "</h2>";
            echo "<table>";
            echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";
            $horas[1] = "8:15 - 9:15";
            $horas[] = "9:15 - 10:15";
            $horas[] = "10:15 - 11:15";
            $horas[] = "11:15 - 11:45";
            $horas[] = "11:45 - 12:45";
            $horas[] = "12:45 - 13:45";
            $horas[] = "13:45 - 14:45";


            for ($i = 1; $i < 8; $i++) {
                echo "<tr><th>" . $horas[$i] . "</th>";

                if ($i == 4) {
                    echo "<th colspan='5'>RECREO</th>";
                } else {
                    for ($j = 1; $j <= 5; $j++) {
                        $url = DIR_SERV . "/obtenerGrupo";
                        $datos["id_usuario"] = $datos_usuario_logeado->id_usuario;
                        $datos["dia"] = $j;
                        $datos["hora"] = $i;
                        $datos["token"] = $_SESSION["token"];

                        $respuesta = consumir_servicios_REST($url, "POST", $datos);
                        $obj = json_decode($respuesta);

                        if (!$obj) {
                            session_destroy();
                            die("<h1>Error servicio</h1><p>Error consumiendo servicios" . $url . "</p></body></html>");
                        }
                        if (isset($obj->error)) {
                            session_destroy();
                            die("<h1>Error servicio</h1><p>Error consumiendo servicios rest " . $obj->error . "</p></body></html>");
                        }
                        if (isset($obj->no_auth)) {
                            session_unset();
                            $_SESSION["seguridad"] = "Tiempo de sesion de la api ha caducado";
                            header("Location:#");
                            exit;
                        }
                        if (isset($obj->mensaje)) {
                            echo "<td></td>";
                        } else {
                            $url = DIR_SERV . "/obtenerNombreGrupo/" . $obj->grupo->grupo;
                            $respuesta = consumir_servicios_REST($url, "GET", $datos);
                            $obj = json_decode($respuesta);

                            if (!$obj) {
                                session_destroy();
                                die("<h1>Error servicio</h1><p>Error consumiendo servicios" . $url . "</p></body></html>");
                            }
                            if (isset($obj->error)) {
                                session_destroy();
                                die("<h1>Error servicio</h1><p>Error consumiendo servicios rest " . $obj->error . "</p></body></html>");
                            }
                            if (isset($obj->no_auth)) {
                                session_destroy();
                                $_SESSION["seguridad"] = "Tiempo de sesion de la api ha caducado";
                                header("Location:#");
                                exit;
                            }
                            if (isset($obj->mensaje)) {
                                session_destroy();
                                die("<h1>Error servicio</h1><p>Error consumiendo servicios rest " . $obj->mensaje . "</p></body></html>");
                            }

                            echo "<td>" . $obj->nombre->nombre . "<br></td>";
                        }
                    }
                }
                echo "</tr>";
            }

            echo "</table>";

            ?>
        </body>

        </html>
    <?php
    }
} else {



    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            .error {
                color: red;
            }

            .mensaje {
                color: blue;
            }
        </style>
    </head>

    <body>

        <h1>Login</h1>
        <form action="#" method="post">

            <p>
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario">
            </p>
            <p>
                <label for="clave">Clave</label>
                <input type="password" name="clave" id="clave">
            </p>
            <p>
                <button type="submit" name="btnLogin">Entrar</button>
            </p>

        </form>

        <?php
        if (isset($_SESSION["seguridad"])) {
            echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
            session_destroy();
        }
        ?>

    </body>

    </html>
<?php
}
?>