<?php
session_name("Examen4_SW_23_24");
session_start();
require "../src/funciones_ctes.php";
if (!isset($_SESSION["usuario"])) {
    header("Location:../index.php");
    exit;
} else {

    if ($_SESSION["tipo"] !== "tutor") {
        session_destroy();
        header("Location:../index.php");
        exit;
    } else {
        if (isset($_POST["btnSalir"])) {
            $datos["api_session"] = $_SESSION["api_session"];
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
            session_destroy();
            header("Location:../index.php");
            exit;
        }

        $url = DIR_SERV . "/logueado";
        $datos["api_session"] = $_SESSION["api_session"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj->error . "</p>"));
        }
        if (isset($obj->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location:../index.php");
            exit;
        }

        if (isset($obj->mensaje)) {
            session_unset();
            $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:../index.php");
            exit;
        }

        $datos_usuario_log = $obj->usuario;

        if (time() - $_SESSION["ult_accion"] > MINUTOS * 60) {
            session_unset();
            $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
            header("Location:../index.php");
            exit;
        }
        $_SESSION["ult_accion"] = time();


        $url = DIR_SERV . "/alumnos";
        $datos["api_session"] = $_SESSION["api_session"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj->error . "</p>"));
        }
        if (isset($obj->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location:../index.php");
            exit;
        }

        if (isset($_POST["btnNotas"]) || isset($_POST["btnEditar"]) || isset($_POST["btnBorrar"]) || isset($_SESSION["mensaje"]) || isset($_POST["btnAtras"])) {

            if (isset($_SESSION["mensaje"])) {
                $_POST["alumnos"] = $_SESSION["alumno"];
            }
            $url = DIR_SERV . "/notasAlumno/" . $_POST["alumnos"];
            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $objN = json_decode($respuesta);
            if (!$objN) {
                session_destroy();
                die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
            }
            if (isset($objN->error)) {
                session_destroy();
                die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $objN->error . "</p>"));
            }
            if (isset($objN->no_auth)) {
                session_unset();
                $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
                header("Location:../index.php");
                exit;
            }

            if (isset($objN->mensaje)) {
                session_unset();
                $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
                header("Location:../index.php");
                exit;
            }
        }
        if (isset($_POST["btnBorrar"])) {

            $url = DIR_SERV . "/quitarNota/" . $_POST["alumnos"];
            $datos["cod_asig"] = $_POST["btnBorrar"];

            $respuesta = consumir_servicios_REST($url, "DELETE", $datos);
            $objQ = json_decode($respuesta);
            if (!$objN) {
                session_destroy();
                die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
            }
            if (isset($objQ->error)) {
                session_destroy();
                die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $objQ->error . "</p>"));
            }
            if (isset($objQ->no_auth)) {
                session_unset();
                $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
                header("Location:../index.php");
                exit;
            }

            $_SESSION["mensaje"] = "Asignatura descalificada con exito";
            $_SESSION["alumno"] = $_POST["alumnos"];
            header("Location:#");
            exit;
        }
        if (isset($_POST["btnEditar"])) {
        }

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Examen4</title>
            <style>
                .enlace {
                    border: none;
                    background: none;
                    cursor: pointer;
                    color: blue;
                    text-decoration: underline;
                }

                .enLinea {
                    display: inline;
                }

                table,
                td,
                th,
                tr {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                th {
                    background-color: lightgrey;
                }

                .azul {
                    color: blue;
                }
            </style>
        </head>

        <body>

            <h1>Notas de los alumnos</h1>
            <div>Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong>
                <form action="index.php" method="post" class="enLinea"><button type="submit" name="btnSalir" class="enlace">Salir</button></form>
            </div>

            <?php

            if (count($obj->alumnos) == 0) {
                echo "<p>En estos momentos no tenemos ningun alumno en la bd</p>";
            } else {

                echo "<form action='#' method='post'>";
                echo "<p>";
                echo "<label for='alum'>Seleccione un alumno</label>";
                echo "<select name='alumnos' id='alum'>";
                foreach ($obj->alumnos as $alumno) {
                    if (isset($_POST["alumnos"]) && $_POST["alumnos"] == $alumno->cod_usu) {
                        echo "<option value='" . $alumno->cod_usu . "' selected>" . $alumno->nombre . "</option>";
                        $nombre = $alumno->nombre;
                    } else {
                        echo "<option value='" . $alumno->cod_usu . "'>" . $alumno->nombre . "</option>";
                    }
                }
                echo "</select>";
                echo "<button type='submit' name='btnNotas''>Ver Notas</button>";
                echo "<p>";
                echo "</form>";
            }
            if (isset($_POST["btnNotas"]) || isset($_POST["btnEditar"]) || isset($_POST["btnBorrar"]) || isset($_SESSION["mensaje"]) || isset($_POST["btnAtras"])) {

                echo "<h2>Notas del Alumno " . $nombre . "</h2>";
                echo "<table>";
                echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
                if (count($objN->notas) != 0) {

                    if (isset($_POST["btnEditar"])) {
                        foreach ($objN->notas as $nota) {

                            if ($_POST["btnEditar"] == $nota->cod_asig) {
                                echo "<tr><td>" . $nota->denominacion . "</td>";
                                echo "<td><form action='#' method='post'>";
                                echo "<input type='text' name='nuevaNota' value='" . $nota->nota . "'/></td>";
                                echo "<td><button type='submit' name='btnCambiar' value='" . $nota->cod_asig . "' class='enlace'>Cambiar</button>-";
                                echo "<button type='submit' name='btnAtras'value='" . $nota->cod_asig . "' class='enlace'>Atras</button>";
                                echo "<input type='hidden' name='alumnos' value='".$_POST["alumnos"]."'/>";
                                echo "</form></td>";
                                echo "</tr>";
                            } else {
                                echo "<tr><td>" . $nota->denominacion . "</td>";
                                echo "<td>" . $nota->nota . "</td>";
                                echo "<td><form action='#' method='post'>";
                                echo "<button type='submit' name='btnEditar' value='" . $nota->cod_asig . "' class='enlace'>Editar</button>-";
                                echo "<button type='submit' name='btnBorrar' value='" . $nota->cod_asig . "' class='enlace'>Borrar</button>";
                                echo "<input type='hidden' name='alumnos' value='" . $_POST["alumnos"] . "'/>";
                                echo "</form></td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        foreach ($objN->notas as $nota) {
                            echo "<tr><td>" . $nota->denominacion . "</td><td>" . $nota->nota . "</td>";
                            echo "<td><form action='#' method='post'>";
                            echo "<button type='submit' name='btnEditar' value='" . $nota->cod_asig . "' class='enlace'>Editar</button>-";
                            echo "<button type='submit' name='btnBorrar' value='" . $nota->cod_asig . "' class='enlace'>Borrar</button>";
                            echo "<input type='hidden' name='alumnos' value='" . $_POST["alumnos"] . "'/>";
                            echo "</form></td>";
                            echo "</tr>";
                        }
                    }
                }
                echo "</table>";


                if (count($objN->notas) == 0) {
                    echo "<p>Asignaturas que le quedan a " . $nombre . " por calificar</p>";
                }
                if (isset($_SESSION["mensaje"])) {

                    echo "<p class='azul'>" . $_SESSION["mensaje"] . "</p>";
                    unset($_SESSION["mensaje"]);
                }
            }

            ?>

        </body>

        </html>

<?php
    }
}
