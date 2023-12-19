<?php
session_name("Examen_17_18");
session_start();
require "ctes_func.php";
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}
if (isset($_POST["btnEntrar"])) {

    //comprobar errores
    $error_usuario = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        try {

            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen Login", "<h1>Primer Login</h1><p>No ha podido conectar a la base de batos: " . $e->getMessage() . "</p>"));
        }

        //consulta si el usuario esta en la bd
        try {
            $consulta = "select * from usuarios where usuario='" . $_POST["nombre"] . "' and clave='" . md5($_POST["clave"]) . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Examen Login", "<h1>Primer Login</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }
        echo $consulta;
        if (mysqli_num_rows($resultado) > 0) {

            $_SESSION["usuario"] = $_POST["nombre"];
            $_SESSION["clave"] = md5($_POST["clave"]);
            $_SESSION["ultima_accion"] = time();
            mysqli_free_result($resultado);
            mysqli_close($conexion);

            header("Location:index.php");
            exit;
        } else {
            $error_usuario = true;
        }


        mysqli_free_result($resultado);
        mysqli_close($conexion);
    }
}


if (isset($_SESSION["usuario"])) {


    try {

        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Examen Login", "<h1>Primer Login</h1><p>No ha podido conectar a la base de batos: " . $e->getMessage() . "</p>"));
    }


    try {
        $consulta = "select * from usuarios where usuario='" . $_SESSION["usuario"] . "' and clave='" . $_SESSION["clave"] . "'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Examen Login", "<h1>Primer Login</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
    }

    if (mysqli_num_rows($resultado) <= 0) {
        mysqli_free_result($resultado);
        mysqli_close($conexion);
        session_unset();
        $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    $datos_usuario_logueado = mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);

    // Ahora control de inactividad

    if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
        mysqli_close($conexion);
        session_unset();
        $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["ultima_accion"] = time();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Logeado</title>
        <style>
            .enlace {
                border: none;
                background: none;
                cursor: pointer;
                color: blue;
                text-decoration: underline;
            }

            .enlinea {
                display: inline
            }
            table{
                border: 1px solid black;
                width: 60%;
                text-align: center;
                
            }
            th{
                background-color: lightgray;
            }
            table img {
            height: 60px;
            width: 60px;
        }
        </style>
    </head>

    <body>
        <h1>VideoClub</h1>
        <div>Bienvenido <strong><?php echo $datos_usuario_logueado["usuario"]; ?></strong> -
            <form class='enlinea' action="index.php" method="post">
                <button class='enlace' type="submit" name="btnSalir">Salir</button>
            </form>
        </div>

        <h2>Listado de Peliculas</h2>
        <?php
        try {
            $consulta = "select * from peliculas";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Examen Login", "<h1>Primer Login</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }

        echo"<table>";
        echo"<tr><th>id</th><th>Titulo</th><th>Carátula</th></tr>";
        while($datos_pelis=mysqli_fetch_assoc($resultado)){
            echo "<tr><td>".$datos_pelis["idPelicula"]."</td><td>".$datos_pelis["titulo"]."</td><td><img src='Img/".$datos_pelis["caratula"]."'/></td></tr>";
        }
        echo"</table>";
        ?>
    </body>

    </html>



<?php
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            .error {
                color: red
            }
        </style>
    </head>

    <body>

        <h1>VideoClub</h1>

        <form action="index.php" method="post">

            <p>
                <label for="nombre">Nombre de usuario:</label>
                <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
                <?php
                if (isset($_POST["btnEntrar"]) && $error_usuario) {
                    if ($_POST["nombre"] == "")
                        echo "<span class='error'> Campo vacío </span>";
                    else
                        echo "<span class='error'> Usuario/Contraseña no registrado en BD </span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" id="clave">
                <?php
                if (isset($_POST["btnEntrar"]) && $error_clave) {
                    if ($_POST["clave"] == "")
                        echo "<span class='error'> Campo vacío </span>";
                    else
                        echo "<span class='error'> Usuario/Contraseña no registrado en BD </span>";
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnEntrar">Entrar</button>
                <button type="submit" name="btnRegistrar" formaction="usuario_nuevo.php">Registrarse</button>
            </p>

        </form>
        <?php
        if (isset($_SESSION["seguridad"])) {
            echo $_SESSION["seguridad"];
            session_destroy();
        }
        ?>

    </body>

    </html>

<?php

}


?>