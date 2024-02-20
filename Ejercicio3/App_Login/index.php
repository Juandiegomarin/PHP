<?php
session_name("Ejercicio3_SW");
session_start();

define("MINUTOS", 5);
define("DIR_SERV", "http://localhost/Proyectos/Ejercicio3/servicios_rest");
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
    $page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '
        
    </body>
    </html>';
    return $page;
}
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}
if (isset($_POST["btnLogin"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_pass = $_POST["pass"] == "";

    $error_form = $error_usuario || $error_pass;

    if (!$error_form) {

        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["pass"]);

        $url = DIR_SERV . "/login";

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) {
            die(error_page("Ejercicio3_SW", "Error pagina " . $respuesta));
            session_destroy();
        }
        if (isset($obj->mensaje_error)) {
            die(error_page("Ejercicio3_SW", $obj->mensaje_error));
            session_destroy();
        }
        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            $_SESSION["usuario"] = $obj->usuario->usuario;
            $_SESSION["clave"] = $obj->usuario->clave;
            $_SESSION["ultima_accion"] = time();

            header("Location:index.php");
            exit;
        }
    }
}

if (isset($_SESSION["usuario"])) {

    $datos["usuario"] = $_SESSION["usuario"];
    $datos["clave"] = $_SESSION["clave"];

    $url = DIR_SERV . "/login";

    $respuesta = consumir_servicios_REST($url, "POST", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) {
        die(error_page("Ejercicio3_SW", "Error pagina " . $respuesta));
        session_destroy();
    }
    if (isset($obj->mensaje_error)) {
        die(error_page("Ejercicio3_SW", $obj->mensaje_error));
        session_destroy();
    }
    if (isset($obj->mensaje)) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ya no se encuentra en la bd";
        header("Location:index.php");
        exit;
    }

    $datos_usuario_log = $obj->usuario;

    if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Su tiempo de sesion ha caducado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["ultima_accion"] = time();

    if ($datos_usuario_log->tipo == "normal") {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Vista Normal</title>
            <style>
                .enlace {
                    background: none;
                    border: none;
                    text-decoration: underline;
                    cursor: pointer;
                    color: blue;
                }

                .enlinea {
                    display: inline;
                }
            </style>
        </head>

        <body>

            <h1>Vista Normal</h1>
            <div >
                Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong>
                <form  class="enlinea" action="index.php" method="post"><button type="submit" name="btnSalir" class="enlace">Salir</button></form>
            </div>

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
            <title>Vista Admin</title>
            <style>
                .enlace {
                    background: none;
                    border: none;
                    text-decoration: underline;
                    cursor: pointer;
                    color: blue;
                }

                .enlinea {
                    display: inline;
                }
            </style>
        </head>

        <body>

            <h1>Vista Admin</h1>
            <div >
                Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong>
                <form  class="enlinea" action="index.php" method="post"><button type="submit" name="btnSalir" class="enlace">Salir</button></form>
            </div>

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
        <title>Login SW</title>
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

        <h1>Login SW</h1>
        <form action="index.php" method="post">

            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
                <?php
                if (isset($_POST["usuario"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } else {
                        echo "<span class='error'>El usuario o la contraseña no estan bien escritas</span>";
                    }
                }
                ?>
            </p>

            <p>
                <label for="pass">Contraseña:</label>
                <input type="password" name="pass" id="pass">
                <?php
                if (isset($_POST["pass"]) && $error_clave) {
                    if ($_POST["pass"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    }
                }
                ?>
            </p>

            <p>
                <button type="submit" name="btnLogin">Login</button>
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