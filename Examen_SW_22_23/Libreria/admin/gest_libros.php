<?php
session_name("Exam_repaso");
session_start();
define("DIR_SERV", "http://localhost/Proyectos/Examen_SW_22_23/servicios_rest");
define("MINUTOS", 2);
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

function error_page($title, $cabecera, $mensaje)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body><h1>' . $cabecera . '</h1>' . $mensaje . '</body></html>';
    return $html;
}

if (isset($_POST["btnSalir"])) {

    session_destroy();
    header("Location:../index.php");
    exit;
}
if (isset($_POST["btnBorrar"])) {
    $_SESSION["mensaje"] = "Libro con referencia " . $_POST["btnBorrar"] . " borrado correctamente";
    header("Location:#");
    exit;
}
if (isset($_POST["btnEditar"])) {
    $_SESSION["mensaje"] = "Libro con referencia " . $_POST["btnEditar"] . " editado correctamente";
    header("Location:#");
    exit;
}
if (isset($_POST["btnAgregar"])) {

    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]) || $_POST["referencia"] <= 0;
    if (!$error_referencia) {

        $url = DIR_SERV . "/repetido/libros/referencia/" . $_POST["referencia"];
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            die(error_page("Error página", "Error página", "Error consumiendo el servicio"));
            session_destroy();
        }
        if (isset($obj->error)) {
            die(error_page("Error página", "Error página", $obj->error));
            session_destroy();
        }

        if ($obj->repetido) {
            $error_referencia = true;
        }
    }
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0;
    $error_portada = $_FILES["foto"]["size"] > 500 * 1024;

    if ($_FILES["foto"]["name"] == "") {
        $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio;
    } else {
        $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio || $error_portada;
    }

    if (!$error_form) {

        $url = DIR_SERV . "/crearLibro";
        $datos["referencia"] = $_POST["referencia"];
        $datos["titulo"] = $_POST["titulo"];
        $datos["autor"] = $_POST["autor"];
        $datos["descripcion"] = $_POST["descripcion"];
        $datos["precio"] = $_POST["precio"];

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            die(error_page("Error página", "Error página", "Error consumiendo el servicio"));
            session_destroy();
        }
        if (isset($obj->error)) {
            die(error_page("Error página", "Error página", $obj->error));
            session_destroy();
        }

        if ($_FILES["foto"]["name"] == "") {
            $_SESSION["mensaje"] = $obj->mensaje . " sin foto";
            header("Location:#");
            exit;
        } else {
        }
    }
}
//seguridad
if (isset($_SESSION["usuario"])) {

    //seguridad


    //control de baneo
    $url = DIR_SERV . "/logeado";

    $datos["token"] = $_SESSION["key"];
    $respuesta = consumir_servicios_REST($url, "POST", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        die(error_page("Error página", "Error página", "Error consumiendo el servicio"));
        session_destroy();
    }
    if (isset($obj->error)) {
        die(error_page("Error página", "Error página", $obj->error));
        session_destroy();
    }
    if (isset($obj->mensaje)) {
        session_unset();
        $_SESSION["seguridad"] = $obj->mensaje;
        header("Location:../index.php");
        exit;
    }
    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = $obj->no_login;
        header("Location:../index.php");
        exit;
    }
    //control de inactividad

    if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo de sesion ha caducado";
        header("Location:../index.php");
        exit;
    }
    $_SESSION["seguridad"] = time();


    //division de usuarios
    if ($_SESSION["tipo"] != "admin") {
        session_destroy();
        header("Location:../index.php");
        exit;
    } else {

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Vista admin</title>
            <style>
                .enlace {
                    background: none;
                    cursor: pointer;
                    border: none;
                    text-decoration: underline;
                    color: blue;
                }

                .enLinea {
                    display: inline;
                }

                th {
                    background-color: lightgray;
                }

                table {
                    width: 60%;
                    margin-left: 20%;
                    text-align: center;
                }

                table,
                tr,
                td,
                th {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                .azul {
                    color: blue;
                }

                .error {
                    color: red;
                }
                .fotito{
                    width: 100px;
                }
            </style>
        </head>

        <body>

            <div>
                Bienvenido <strong><?php echo $_SESSION["usuario"] ?></strong>
                <form action="#" method="post" class="enLinea"><button type="submit" name="btnSalir" class="enlace">Salir</button></form>
            </div>
            <?php
            if (isset($_POST["btnDetalle"])) {

                $url = DIR_SERV . "/obtenerLibro/" . $_POST["btnDetalle"];
                $respuesta = consumir_servicios_REST($url, "GET");
                $obj = json_decode($respuesta);
                
                if (!$obj) {
                    die("<p>Error consumiendo el servicio</p></body></html>" . $respuesta);
                    session_destroy();
                }
                if (isset($obj->error)) {
                    die("<p>" . $obj->error . "</p></body></html>");
                    session_destroy();
                }
                if(isset($obj->mensaje)){
                    die("<p>" . $obj->mensaje . "</p></body></html>");
                    session_destroy();
                }else{
                    echo "<h1>Datos de libro con referencia " . $_POST["btnDetalle"] . "</h1>";

                    echo "<p><strong>Titulo: </strong>".$obj->libro->titulo."</p>";
                    echo "<p><strong>Autor: </strong>".$obj->libro->autor."</p>";
                    echo "<p><strong>Descripcion: </strong>".$obj->libro->descripcion."</p>";
                    echo "<p><strong>Precio: </strong>".$obj->libro->precio."</p>";
                    echo "<p><strong>Portada: </strong><img src='../images/".$obj->libro->portada."' class='fotito'/></p>";
                }
                
            }

            if (isset($_SESSION["mensaje"])) {
                echo "<p class='azul'>" . $_SESSION["mensaje"] . "</p>";
                unset($_SESSION["mensaje"]);
            }
            ?>
            <h1>Listado de libros</h1>
            <?php
            $url = DIR_SERV . "/libros";
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);
            if (!$obj) {
                die("<p>Error consumiendo el servicio</p></body></html>" . $respuesta);
                session_destroy();
            }
            if (isset($obj->error)) {
                die("<p>" . $obj->error . "</p></body></html>");
                session_destroy();
            }
            echo "<table>";
            echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
            foreach ($obj->libros as $libro) {
                echo "<tr><td>" . $libro->referencia . "</td><td><form action='#' method='post'><button type='submit' name='btnDetalle' value='" . $libro->referencia . "' class='enlace'>" . $libro->titulo . "</button></form></td><td><form action='#' method='post'><button type='submit' name='btnBorrar' value='" . $libro->referencia . "' class='enlace'>Borrar</button> - <button type='submit' name='btnEditar' value='" . $libro->referencia . "' class='enlace'>Editar</button></form></td></tr>";
            }
            echo "</table>";
            ?>


            <h1>Agregar nuevo libro</h1>
            <form action="#" method="post">
                <p>
                    <label for="referencia">Referencia: </label>
                    <input type="text" name="referencia" id="referencia">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_referencia) {
                        if ($_POST["referencia"] == "") {
                            echo "<span class='error'>Campo vacio</span>";
                        } else if (!is_numeric($_POST["referencia"])) {
                            echo "<span class='error'>No has escrito un valor numerico</span>";
                        } else if ($_POST["referencia"] <= 0) {
                            echo "<span class='error'>No se puede introducir una referencia menor o igual a 0</span>";
                        } else {
                            echo "<span class='error'>Referencia repetida</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="titulo">Titulo: </label>
                    <input type="text" name="titulo" id="titulo">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_titulo) {
                        if ($_POST["titulo"] == "") {
                            echo "<span class='error'>Campo vacio</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="autor">Autor: </label>
                    <input type="text" name="autor" id="autor">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_autor) {
                        if ($_POST["autor"] == "") {
                            echo "<span class='error'>Campo vacio</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="descripcion">Descripcion: </label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="3"></textarea>
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_descripcion) {
                        if ($_POST["descripcion"] == "") {
                            echo "<span class='error'>Campo vacio</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="precio">Precio: </label>
                    <input type="text" name="precio" id="precio">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_precio) {
                        if ($_POST["precio"] == "") {
                            echo "<span class='error'>Campo vacio</span>";
                        } else if (!is_numeric($_POST["precio"])) {
                            echo "<span class='error'>No has escrito un valor numerico</span>";
                        } else {
                            echo "<span class='error'>No se puede introducir una precio menor o igual a 0</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="foto">Elija una foto</label>
                    <input type="file" name="foto" id="foto">
                </p>
                <p>
                    <button type="submit" name="btnAgregar">Agregar</button>
                </p>

            </form>
        </body>

        </html>


<?php






    }
} else {
    session_destroy();
    header("Location:../index.php");
    exit;
}
