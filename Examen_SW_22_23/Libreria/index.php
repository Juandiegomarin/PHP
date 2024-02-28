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

//boton salir
if (isset($_POST["btnSalir"])) {

    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnLogin"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;
    if (!$error_form) {

        $url = DIR_SERV . "/login";

        $datos["lector"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

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

        if (isset($obj->usuario)) {

            $_SESSION["usuario"] = $obj->usuario->lector;
            $_SESSION["clave"] = $obj->usuario->clave;
            $_SESSION["tipo"] = $obj->usuario->tipo;
            $_SESSION["key"] = $obj->api_sesion;
            $_SESSION["tipo"] = $obj->usuario->tipo;
            $_SESSION["ultima_accion"] = time();

            header("Location:index.php");
            exit;
        } else {
            $error_usuario = true;
        }
    }
}

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
        header("Location:index.php");
        exit;
    }
    if (isset($obj->no_login)) {
        session_unset();
        $_SESSION["seguridad"] = $obj->no_login;
        header("Location:index.php");
        exit;
    }
    //control de inactividad

    if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo de sesion ha caducado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["seguridad"] = time();


    //division de usuarios
    if ($_SESSION["tipo"] == "admin") {

        header("Location:./admin/gest_libros.php");
        exit;

    } else {
    ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Vista normal</title>
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

                #libros {
                    display: flex;
                    flex-flow: row wrap;
                }

                #libros>div {
                    display: flex;
                    flex-direction: column;
                    flex: 0 33%;
                    align-items: center;
                }

                #libros>div>img {
                    width: 30%;
                    height: auto;
                }
            </style>
        </head>

        <body>

            <div>
                Bienvenido <strong><?php echo $_SESSION["usuario"] ?></strong>
                <form action="#" method="post" class="enLinea"><button type="submit" name="btnSalir" class="enlace">Salir</button></form>
            </div>
            <?php
            echo "<h1>Listado de libros</h1>";
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

            echo "<div id='libros'>";
            foreach ($obj->libros as $libro) {

                echo "<div><img src='images/" . $libro->portada . "'/><span>" . $libro->titulo . " - " . $libro->precio . "€</span></div>";
            }
            echo "<div>";
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
        <title>Inicio de Sesión</title>
        <style>
            #libros {
                display: flex;
                flex-flow: row wrap;
            }

            #libros>div {
                display: flex;
                flex-direction: column;
                flex: 0 33%;
                align-items: center;
            }

            #libros>div>img {
                width: 30%;
                height: auto;
            }

            .error {
                color: red;
            }

            .azul {
                color: blue;
            }
        </style>
    </head>

    <body>

        <h1>Login Principal</h1>

        <form action="index.php" method="post">

            <p>
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
                <?php
                if (isset($_POST["usuario"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>Campo vacio</span>";
                    } else {
                        echo "<span class='error'>Usuario/contraseña mal escrita</span>";
                    }
                }

                ?>
            </p>
            <p>
                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave">
                <?php
                if (isset($_POST["clave"]) && $error_clave) {
                    if ($_POST["clave"] == "") {
                        echo "<span class='error'>Campo vacio</span>";
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
            echo "<p class='azul'>" . $_SESSION["seguridad"] . "</p>";
            session_destroy();
        }
        echo "<h1>Listado de libros</h1>";
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

        echo "<div id='libros'>";
        foreach ($obj->libros as $libro) {

            echo "<div><img src='images/" . $libro->portada . "'/><span>" . $libro->titulo . " - " . $libro->precio . "€</span></div>";
        }
        echo "<div>";

        ?>

    </body>

    </html>
<?php
}
?>