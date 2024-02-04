<?php
session_name("Full");
session_start();
require "../src/funciones_constantes.php";
if (isset($_POST["btnSalir"])) {

    session_destroy();
    header("Location:index.php");
    exit;
}
if (isset($_POST["btnLogin"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_nombre || $error_clave;
    if (!$error_form) {

        $url = DIR_SERV . "/login";

        $datos["usuario"] = $_POST["nombre"];
        $clave_encriptada = md5($_POST["clave"]);
        $datos["clave"] = $clave_encriptada;

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("Error página", "Error consumiendo el servicio" . $respuesta));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Error página", $obj->error));
        }
        if (isset($obj->mensaje)) {
            $error_nombre = true;
        } else {
            $_SESSION["usuario"] = $obj->usuario->usuario;
            $_SESSION["clave"] = $obj->usuario->clave;
            $_SESSION["tipo"] = $obj->usuario->tipo;
            $_SESSION["token"] = $obj->token;
            $_SESSION["ultima_accion"] = time();

            header("Location:index.php");
            exit;
        }
    }
}
if (isset($_POST["btnContBorrar"])) {

    $url = DIR_SERV . "/borrarUsuario/" . urlencode($_POST["btnContBorrar"]);
    $respuesta = consumir_servicios_REST($url, "DELETE");
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die("<p>Error consumiendo servicios rest " . $respuesta . "</p></body></html>");
    }
    if (isset($obj->error)) {
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }
    $_SESSION["mensaje"] = $obj->mensaje;
    header("Location:index.php");
    exit;
}
if (isset($_POST["btnContInsertar"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {

        $url = DIR_SERV . "/repetido/usuarios/usuario/" . urlencode($_POST["usuario"]);
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Error página", "Error consumiendo el servicio" . $respuesta));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Error página", $obj->error));
        }
        if ($obj->repetido) {
            $error_usuario = true;
        }
    }
    $error_clave = $_POST["clave"] == "";
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    if (!$error_form) {

        $url = DIR_SERV . "/crearUsuario";

        $datos["nombre"] = $_POST["nombre"];
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);
        $datos["email"] = $_POST["email"];

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Error página", "Error consumiendo el servicio" . $respuesta));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Error página", $obj->error));
        }

        $_SESSION["mensaje"] = $obj->mensaje;
        header("Location:index.php");
        exit;
    }
}
if (isset($_POST["btnContEditar"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {

        $url = DIR_SERV . "/repetido/usuarios/usuario/" . urlencode($_POST["usuario"]) . "/id_usuario/" . urlencode($_POST["btnContEditar"]);
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Error página", "Error consumiendo el servicio" . $respuesta));
        }
        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Error página", $obj->error));
        }
        if ($obj->repetido) {
            $error_usuario = true;
        }
    }
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    $error_form = $error_nombre || $error_usuario || $error_email;

    if (!$error_form) {

        if ($_POST["clave"] == "") {
           
            $url = DIR_SERV . "/actualizarUsuario/" . urlencode($_POST["btnContEditar"]);

            $datos["nombre"] = $_POST["nombre"];
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $datos["email"] = $_POST["email"];

            $respuesta = consumir_servicios_REST($url, "PUT", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();
                die(error_page("Error página", "Error consumiendo el servicio" . $respuesta));
            }
            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Error página", $obj->error));
            }

            $_SESSION["mensaje"] = $obj->mensaje;
           header("Location:index.php");
           exit;
        } else {

            $url = DIR_SERV . "/actualizarUsuarioSinClave/" . urlencode($_POST["btnContEditar"]);

            $datos["nombre"] = $_POST["nombre"];
            $datos["usuario"] = $_POST["usuario"];
            $datos["email"] = $_POST["email"];

            $respuesta = consumir_servicios_REST($url, "PUT", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();
                die(error_page("Error página", "Error consumiendo el servicio" . $respuesta));
            }
            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Error página", $obj->error));
            }

            $_SESSION["mensaje"] = $obj->mensaje;
            header("Location:index.php");
            exit;
        }
    }
}
if (isset($_SESSION["usuario"])) {

    //seguridad
    $url = DIR_SERV . "/logeado";
    $datos["token"] = $_SESSION["token"];
    $respuesta = consumir_servicios_REST($url, "POST", $datos);

    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die("<p>Error consumiendo servicios rest " . $respuesta . "</p></body></html>");
    }
    if (isset($obj->error)) {
        die("<p>" . $obj->error . "</p></body></html>");
    }
    if (!isset($obj->usuario)) {
        
        session_unset();
        
        $_SESSION["seguridad"] = "Ya no se encuentra en la base de datos";
       header("Location:index.php");
       exit;
    }

    if (time() - $_SESSION["ultima_accion"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Tiempo de sesion caducado";
        header("Location:index.php");
        exit;
    }
    $_SESSION["ultima_accion"] = time();

    if ($_SESSION["tipo"] == "admin") {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Vista admin</title>
            <style>
                .enlace {
                    cursor: pointer;
                    background: none;
                    border: none;
                    text-decoration: underline;
                    color: blue;
                }

                .enLinea {
                    display: inline;
                }

                table,
                th,
                td {
                    border: 1px solid black;
                    border-collapse: collapse;
                    text-align: center;
                }

                table {
                    width: 60%;
                }

                th {
                    background-color: lightgray;
                }

                .azul {
                    color: blue;
                }

                .error {
                    color: red;
                }
            </style>
        </head>

        <body>
            <div>
                Bienvenido <strong><?php echo $_SESSION["usuario"] ?></strong>
                <form action='index.php' method='post' class="enLinea"><button type='submit' name='btnSalir' class='enlace'>Salir</button></form>
            </div>
            <?php
            if (isset($_POST["btnDetalle"])) {
                $url = DIR_SERV . "/usuario/" . urlencode($_POST["btnDetalle"]);
                $respuesta = consumir_servicios_REST($url, "GET");
                $obj = json_decode($respuesta);

                if (!$obj) {
                    session_destroy();
                    die("<p>Error consumiendo servicios rest " . $respuesta . "</p></body></html>");
                }
                if (isset($obj->error)) {
                    session_destroy();
                    die("<p>" . $obj->error . "</p></body></html>");
                }

                echo "<h1>Datos del usuario con id " . $obj->usuario->id_usuario . "</h1>";
                echo "<p><strong>Nombre: </strong>" . $obj->usuario->nombre . "</p>";
                echo "<p><strong>Usuario: </strong>" . $obj->usuario->usuario . "</p>";
                echo "<p><strong>Email: </strong>" . $obj->usuario->email . "</p>";
                echo "<p><strong>Tipo: </strong>" . $obj->usuario->tipo . "</p>";

                echo " <p><form method='post' action='index.php'><button type='submit'>Salir</button></form></p>";
            }
            if (isset($_POST["btnBorrar"])) {

                echo "<p>Seguro que quieres borrar el usuario con id: " . $_POST["btnBorrar"] . "</p>";
                echo " <p><form method='post' action='index.php'><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Si</button><button type='submit'>No</button></form></p>";
            }

            if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {

            ?>
                <form action="index.php" method="post">
                    <p>
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                            if ($_POST["nombre"] == "") {
                                echo "<span class='error'>Campo vacio</span>";
                            }
                        }
                        ?>
                    </p>
                    <p>
                        <label for="usuario">Usuario:</label>
                        <input type="text" name="usuario" id="usuario">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_usuario) {
                            if ($_POST["usuario"] == "") {
                                echo "<span class='error'>Campo vacio</span>";
                            } else {
                                echo "<span class='error'>Usuario Repetido</span>";
                            }
                        }
                        ?>
                    </p>
                    <p>
                        <label for="clave">Clave:</label>
                        <input type="password" name="clave" id="clave">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_clave) {
                            if ($_POST["clave"] == "") {
                                echo "<span class='error'>Campo vacio</span>";
                            }
                        }
                        ?>

                    </p>
                    <p>
                        <label for="email">Email:</label>
                        <input type="text" name="email" id="email">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_email) {
                            if ($_POST["email"] == "") {
                                echo "<span class='error'>Campo vacio</span>";
                            } else {
                                echo "<span class='error'>Has introducido un email no valido</span>";
                            }
                        }
                        ?>
                    </p>
                    <p>
                        <button type="submit" name="btnContInsertar">Insertar</button>
                        <button type="submit">Volver</button>
                    </p>

                </form>

            <?php
            }
            if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"])) {

                if (isset($_POST["btnEditar"])) {
                    $cod = $_POST["btnEditar"];
                } else {
                    $cod = $_POST["btnContEditar"];
                }
                echo "<h1>Editando usuario con codigo " . $cod . "</h1>";
                $url = DIR_SERV . "/usuario/" . urlencode($cod);
                $respuesta = consumir_servicios_REST($url, "GET");
                $obj = json_decode($respuesta);

                if (!$obj) {
                    session_destroy();
                    die("<p>Error consumiendo servicios rest " . $respuesta . "</p></body></html>");
                }
                if (isset($obj->error)) {
                    session_destroy();
                    die("<p>" . $obj->error . "</p></body></html>");
                }

                $name = $obj->usuario->nombre;
                $usu = $obj->usuario->usuario;
                $eme = $obj->usuario->email;
                $tip = $obj->usuario->tipo;
            ?>
                <form action="index.php" method="post">
                    <p>
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["btnEditar"])) echo $name;
                                                                            else echo $_POST["nombre"]; ?>">
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_nombre) {
                            if ($_POST["nombre"] == "") {
                                echo "<span class='error'>Campo vacio</span>";
                            }
                        }
                        ?>
                    </p>
                    <p>
                        <label for="usuario">Usuario:</label>
                        <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["btnEditar"])) echo $usu;
                                                                                else echo $_POST["usuario"]; ?>">
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_usuario) {
                            if ($_POST["usuario"] == "") {
                                echo "<span class='error'>Campo vacio</span>";
                            } else {
                                echo "<span class='error'>Usuario Repetido</span>";
                            }
                        }
                        ?>
                    </p>
                    <p>
                        <label for="clave">Clave:</label>
                        <input type="password" name="clave" id="clave">
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_clave) {
                            if ($_POST["clave"] == "") {
                                echo "<span class='error'>Campo vacio</span>";
                            }
                        }
                        ?>

                    </p>
                    <p>
                        <label for="email">Email:</label>
                        <input type="text" name="email" id="email" value="<?php if (isset($_POST["btnEditar"])) echo $eme;
                                                                            else echo $_POST["email"]; ?>"">
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_email) {
                            if ($_POST["email"] == "") {
                                echo "<span class='error'>Campo vacio</span>";
                            } else {
                                echo "<span class='error'>Has introducido un email no valido</span>";
                            }
                        }
                        ?>
                    </p>

                    <p>
                        <select name=" tipo" id="tipo">
                        <option <?php if (isset($_POST["tipo"]) && $_POST["tipo"] == "admin") echo "selected";
                                else if ($tip == "admin") echo "selected" ?> value="admin">Admin</option>
                        <option <?php if (isset($_POST["tipo"]) && $_POST["tipo"] == "normal") echo "selected";
                                else if ($tip == "normal") echo "selected" ?> value="normal">Normal</option>
                        </select>
                    </p>

                    <p>
                        <button type="submit" name="btnContEditar" value="<?php echo $cod ?>">Editar</button>
                        <button type="submit">Volver</button>
                    </p>

                </form>

            <?php

            }



            $url = DIR_SERV . "/usuarios";
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);
            if (!$obj) {
                session_destroy();
                die("<p>Error consumiendo servicios rest " . $respuesta . "</p></body></html>");
            }
            if (isset($obj->error)) {
                session_destroy();
                die("<p>" . $obj->error . "</p></body></html>");
            }
            echo "<h1>Listado de los usuarios</h1>";
            echo "<table>";
            echo "<tr><th>Nombre</th><th>Borrar</th><th>Editar</th></tr>";
            foreach ($obj->usuarios as $usuario) {

                echo "<tr><td><form method='post' action='index.php'><button type='submit' name='btnDetalle' class='enlace' value='" . $usuario->id_usuario . "'>" . $usuario->usuario . "</button></form></td><td><form method='post' action='index.php'><button type='submit' name='btnBorrar' class='enlace' value='" . $usuario->id_usuario . "'>Borrar</button></form></td><td><form method='post' action='index.php'><button type='submit' name='btnEditar' class='enlace' value='" . $usuario->id_usuario . "'>Editar</button></form></td></tr>";
            }
            echo "</table>";
            echo " <p><form method='post' action='index.php'><button type='submit' name='btnInsertar'>Insertar nuevo usuario</button></form></p>";

            if (isset($_SESSION["mensaje"])) {
                echo "<p class='azul'>" . $_SESSION["mensaje"] . "</p>";
                unset($_SESSION["mensaje"]);
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
                .enlace {
                    cursor: pointer;
                    background: none;
                    border: none;
                    text-decoration: underline;
                    color: blue;
                }

                .enLinea {
                    display: inline;
                }
            </style>
        </head>

        <body>
            <div>
                Bienvenido <strong><?php echo $_SESSION["usuario"] ?></strong>
                <form action='index.php' method='post' class="enLinea"><button type='submit' name='btnSalir' class='enlace'>Salir</button></form>
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
        <title>Login SW Restringuido</title>
        <style>
            .pulsado {
                cursor: pointer;
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

        <h1>Login</h1>
        <form action="index.php" method="post">

            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
                <?php
                if (isset($_POST["nombre"]) && $error_nombre) {
                    if ($_POST["nombre"] == "") {
                        echo "<span class='error'>Campo vacio</span>";
                    } else {
                        echo "<span class='error'>Usuario/Contraseña mal escritas</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
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
                <button type="submit" name="btnLogin" class="pulsado">Entrar</button>
            </p>
        </form>
        <?php
        if (isset($_SESSION["seguridad"])) {
            echo "<p class='azul'>" . $_SESSION["seguridad"] . "</p>";
            session_destroy();
        }
        ?>
    </body>

    </html>
<?php
}
?>