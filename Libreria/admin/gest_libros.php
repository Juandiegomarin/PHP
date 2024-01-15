<?php
session_name("examen3_22_23");
session_start();
define("MINUTOS", 2);
function error_page($title, $body)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' . $body . '</body></html>';
    return $html;
}
function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{
    try {
        if (isset($columna_clave))
            $consulta = "select * from " . $tabla . " where " . $columna . "='" . $valor . "' AND " . $columna_clave . "<>'" . $valor_clave . "'";
        else
            $consulta = "select * from " . $tabla . " where " . $columna . "='" . $valor . "'";

        $resultado = mysqli_query($conexion, $consulta);
        $respuesta = mysqli_num_rows($resultado) > 0;
        mysqli_free_result($resultado);
    } catch (Exception $e) {
        $respuesta = $e->getMessage();
    }
    return $respuesta;
}
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:../index.php");
    exit;
}

if (isset($_SESSION["usuario"])) {

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
        header("Location:../index.php");
        exit;
    }
    $datos_usuario_logeado = mysqli_fetch_assoc($resultado);

    if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo transcurrido";
        header("Location:../index.php");
        exit;
    }
    $_SESSION["ultima_accion"] = time();

    if ($datos_usuario_logeado["tipo"] != "admin") {
        session_destroy();
        header("Location:../index.php");
        exit;
    }

    if (isset($_POST["btnAgregar"])) {

        $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]) || $_POST["referencia"] <= 0;
        if (!$error_referencia) {

            try {

                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_libreria_exam");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                session_destroy();
                die(error_page("Logeo", "No se ha realizar la consulta" . $e->getMessage()));
            }
        }
        $error_titulo = $_POST["titulo"] == "";
        $error_autor = $_POST["autor"] == "";
        $error_descripcion = $_POST["descripcion"] == "";
        $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0;

        $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio;

        if (!$error_form) {
            try {

                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_libreria_exam");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                session_destroy();
                die(error_page("Logeo", "No se ha realizar la consulta" . $e->getMessage()));
            }

            try {

                $consulta = "insert into libros(`referencia`, `titulo`, `autor`, `descripcion`, `precio`) VALUES ('" . $_POST["referencia"] . "','" . $_POST["titulo"] . "','" . $_POST["autor"] . "','" . $_POST["descripcion"] . "','" . $_POST["precio"] . "')";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                session_destroy();
                mysqli_close($conexion);
                die(error_page("Logeo", "No se ha realizar la consulta" . $e->getMessage()));
            }
            mysqli_close($conexion);


            $extension = end(explode(".", $_POST["portada"]));

            $nombre_nuevo = "img" . $_POST["referencia"] . $extension;
        }
    }

    if (isset($_POST["btnBorrar"])) {
        $_SESSION["mensaje"] = "El libro con Referencia " . $_POST["btnBorrar"] . " ha sido borrado con éxito";
    }
    if (isset($_POST["btnEditar"])) {
        $_SESSION["mensaje"] = "El libro con Referencia " . $_POST["btnEditar"] . " ha sido editado con éxito";
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Logeado Admin</title>
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

            table {
                border-collapse: collapse;
                text-align: center;
                width: 80%;
            }

            table,
            tr,
            th,
            td {
                border: 1px solid black;
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
        <h1>Librería</h1>
        <div class="enLinea">
            <p>Bienvenido <strong><?php echo $_SESSION["usuario"] ?></strong></p>
            <form action="gest_libros.php" method="post">
                <button class="enlace" type="submit" name="btnSalir">Salir</button>
            </form>
        </div>
        <?php
        if (isset($_SESSION["mensaje"])) {
            echo "<p class='azul'>" . $_SESSION["mensaje"] . "</p>";
            unset($_SESSION["mensaje"]);
        }
        ?>
        <h2>Listado de libros</h2>
        <?php
        echo "<table>";
        echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";

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

            echo "<tr><td>" . $datos["referencia"] . "</td><td>" . $datos["titulo"] . "</td><td><form action='gest_libros.php' method='post'><button class='enlace' type='submit' name='btnBorrar' value='" . $datos["referencia"] . "'>Borrar</button>-<button class='enlace' type='submit' name='btnEditar' value='" . $datos["referencia"] . "'>Editar</button></form></td></tr>";
        }

        mysqli_free_result($resultado);
        echo "</table>";

        ?>

        <h2>Agregar un nuevo libro</h2>
        <form action="gest_libros.php" method="post">

            <p>
                <label for="referencia">Referencia:</label>
                <input type="text" name="referencia" id="referencia" value=<?php if (isset($_POST["referencia"])) echo $_POST["referencia"] ?>>
                <?php
                if (isset($_POST["btnAgregar"]) && $error_referencia) {
                    if ($_POST["referencia"] == "") {
                        echo "<span class='error'>Esta vacío</span>";
                    } else if (!is_numeric($_POST["referencia"])) {
                        echo "<span class='error'>No es un número</span>";
                    } else if ($_POST["referencia"] <= 0) {
                        echo "<span class='error'>No puede ser menor o igual que 0</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="titulo">Titulo:</label>
                <input type="text" name="titulo" id="titulo" value=<?php if (isset($_POST["titulo"])) echo $_POST["titulo"] ?>>
                <?php
                if (isset($_POST["btnAgregar"]) && $error_titulo) {
                    if ($_POST["titulo"] == "") {
                        echo "<span class='error'>Esta vacío</span>";
                    } 
                }
                ?>
            </p>
            <p>
                <label for="autor">Autor:</label>
                <input type="text" name="autor" id="autor" value=<?php if (isset($_POST["autor"])) echo $_POST["autor"] ?>>
                <?php
                if (isset($_POST["btnAgregar"]) && $error_autor) {
                    if ($_POST["autor"] == "") {
                        echo "<span class='error'>Esta vacío</span>";
                    } 
                }
                ?>
            </p>
            <p>
                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" id="descripcion" value=<?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"] ?>>
                <?php
                if (isset($_POST["btnAgregar"]) && $error_descripcion) {
                    if ($_POST["descripcion"] == "") {
                        echo "<span class='error'>Esta vacío</span>";
                    } 
                }
                ?>
            </p>
            <p>
                <label for="precio">Precio:</label>
                <input type="text" name="precio" id="precio" value=<?php if (isset($_POST["precio"])) echo $_POST["precio"] ?>>
                <?php
                if (isset($_POST["btnAgregar"]) && $error_precio) {
                    if ($_POST["precio"] == "") {
                        echo "<span class='error'>Esta vacío</span>";
                    } else if (!is_numeric($_POST["precio"])) {
                        echo "<span class='error'>No es un número</span>";
                    } else if ($_POST["precio"] <= 0) {
                        echo "<span class='error'>No puede ser menor o igual que 0</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="portada">Portada:</label>
                <input type="file" name="portada" id="portada">
            </p>
            <p>
                <button type="submit" name="btnAgregar">Agregar</button>
            </p>


        </form>
    </body>

    </html>
<?php

} else {
    session_destroy();
    header("Location:../index.php");
    exit;
}
