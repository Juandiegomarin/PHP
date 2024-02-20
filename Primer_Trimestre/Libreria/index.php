<?php
session_name("examen3_22_23");
session_start();
define("MINUTOS",2);

function error_page($title, $body)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' . $body . '</body></html>';
    return $html;
}
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}
if (isset($_POST["btnEntrar"])) {

    //errores
    $error_usuario = $_POST["usuario"] == "";
    $error_contraseña = $_POST["contraseña"] == "";

    $error_form = $error_usuario || $error_contraseña;

    if (!$error_form) {

        try {

            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_libreria_exam");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Logeo", "No se ha realizar la consulta" . $e->getMessage()));
        }

        try {

            $consulta = "select * from usuarios where lector='" . $_POST["usuario"] . "' and clave='" . md5($_POST["contraseña"]) . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Logeo", "No se ha realizar la consulta" . $e->getMessage()));
        }
        mysqli_close($conexion);


        if (mysqli_num_rows($resultado) > 0) {
            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["contraseña"] = md5($_POST["contraseña"]);
            $_SESSION["ultima_accion"] = time();
            mysqli_free_result($resultado);
            header("Location:index.php");
            exit;
        } else {
            $error_usuario = true;
        }
    }
}

if (isset($_SESSION["usuario"])) {

    // seguridad
    try {

        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_libreria_exam");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Logeo", "No se ha realizar la consulta" . $e->getMessage()));
    }

    try {

        $consulta = "select * from usuarios where lector='" . $_SESSION["usuario"] . "' and clave='" . $_SESSION["contraseña"] . "'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Logeo", "No se ha realizar la consulta" . $e->getMessage()));
    }
    mysqli_close($conexion);

    if (mysqli_num_rows($resultado) == 0) {
        session_destroy();
        mysqli_free_result($resultado);
        $_SESSION["seguridad"] = "Usted ya no se encuentra en la bd";
        header("Location:index.php");
        exit;
    }
    $datos_usuario_logeado = mysqli_fetch_assoc($resultado);

    if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo transcurrido";
        header("Location:index.php");
        exit;
    }
    $_SESSION["ultima_accion"] = time();

    if ($datos_usuario_logeado["tipo"] == "admin") {
        header("Location:admin/gest_libros.php");
    } else {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Logeado</title>
            <style>
                .enLinea {
                    display: inline;
                }

                .enlace {
                    color: blue;
                    text-decoration: underline;
                    border: none;
                    background: none;
                    cursor: pointer;
                }

                #contenedor {
                    display: flex;
                    flex-flow: row wrap;
                }

                #contenedor>div {
                    display: flex;
                    flex: 0 33%;
                    flex-direction: column;
                    align-items: center;
                }

                img {
                    flex: 100%;
                    height: auto;
                    width: 33%;


                }
            </style>
        </head>

        <body>

            <div>
                Bienvenido <strong><?php echo $_SESSION["usuario"] ?></strong>
                <form class="enLinea" action="index.php" method="post">
                    <button class="enlace" type="submit" name="btnSalir">Salir</button>
                </form>
            </div>
            <h2>Listado de libros</h2>
            <div id="contenedor">
                <?php

                try {

                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_libreria_exam");
                    mysqli_set_charset($conexion, "utf8");
                } catch (Exception $e) {
                    session_destroy();
                    die("No se ha podido conectar a la base de datos" . $e->getMessage());
                }


                try {

                    $consulta = "select * from libros";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    session_destroy();
                    mysqli_close($conexion);
                    die("No se ha podido conectar a la base de datos" . $e->getMessage());
                }
                mysqli_close($conexion);

                while ($datos = mysqli_fetch_assoc($resultado)) {

                    echo "<div><img src='Images/" . $datos["portada"] . "'/><span>" . $datos["titulo"] . "-" . $datos["precio"] . "</span></div>";
                }
                mysqli_free_result($resultado);


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
            #contenedor {
                display: flex;
                flex-flow: row wrap;
            }

            div {
                display: flex;
                flex: 0 33%;
                flex-direction: column;
                align-items: center;
            }

            img {
                flex: 100%;
                height: auto;
                width: 33%;


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

        <h1>Libreria</h1>

        <form action="index.php" method="post">

            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value=<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>>
                <?php
                if (isset($_POST["btnEntrar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>Esta vacío</span>";
                    } else {
                        echo "<span class='error'>Usuario y/o contraseña incorrectos</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="contraseña">Contraseña:</label>
                <input type="password" name="contraseña" id="contraseña">
                <?php
                if (isset($_POST["btnEntrar"]) && $error_contraseña) {
                    if ($_POST["contraseña"] == "") {
                        echo "<span class='error'>Esta vacío</span>";
                    }
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnEntrar">Entrar</button>
            </p>


        </form>
        <?php
        if (isset($_SESSION["seguridad"])) {
            echo "<p class='azul'>" . $_SESSION["seguridad"] . "</p>";
            session_destroy();
        }
        ?>

        <h2>Listado de libros</h2>
        <div id="contenedor">
            <?php

            try {

                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_libreria_exam");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                session_destroy();
                die("No se ha podido conectar a la base de datos" . $e->getMessage());
            }


            try {

                $consulta = "select * from libros";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                session_destroy();
                mysqli_close($conexion);
                die("No se ha podido conectar a la base de datos" . $e->getMessage());
            }
            mysqli_close($conexion);

            while ($datos = mysqli_fetch_assoc($resultado)) {

                echo "<div><img src='Images/" . $datos["portada"] . "'/><span>" . $datos["titulo"] . "-" . $datos["precio"] . "</span></div>";
            }
            mysqli_free_result($resultado);


            ?>
        </div>
    </body>

    </html>
<?php
    
}
?>