<?php
if (isset($_POST["btnContBorrar"])) {

    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("<h1>Primer CRUD</h1>", "<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p>"));
    }
    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}
if (isset($_POST["btnContEditar"])) {

    $error_nombre = $_POST["name"] == "" || strlen($_POST["name"]) > 30;
    $error_usuario = $_POST["usu"] == "" || strlen($_POST["usu"]) > 20;
    

    $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usu"], "id_usuario", $_POST["btnContEditar"]);
    if (is_string($error_usuario)) {

        die($error_usuario);
    }
    $error_pass = strlen($_POST["pass"]) > 15;
    $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || strlen($_POST["email"]) > 50;
    if (!$error_email) {

        if (!isset($conexion)) {

            try {
                //Realizar conexión
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro2
");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("<h1>Primer CRUD</h1>", "<p>No ha podido conectarse a la a base de datos:" . $e->getMessage() . "</p>"));
            }
        }


        $error_email = repetido($conexion, "usuarios", "email", $_POST["email"], "id_usuario", $_POST["btnContEditar"]);
        if (is_string($error_email)) {

            die($error_email);
        }
    }

    $error_form = $error_nombre || $error_usuario || $error_pass || $error_email;
    if (!$error_form) {
        try {
            if ($_POST["pass"] == "") {
                $consulta = "update usuarios set nombre='" . $_POST["name"] . "',usuario='" . $_POST["usu"] . "',email='" . $_POST["email"] . "' where id_usuario='" . $_POST["btnContEditar"] . "'";
            } else
                $consulta = "update usuarios set nombre='" . $_POST["name"] . "',usuario='" . $_POST["usu"] . "',clave='" . md5($_POST["pass"]) . "',email='" . $_POST["email"] . "' where id_usuario='" . $_POST["btnContEditar"] . "'";

            mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("<h1>Primer CRUD</h1>", "<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p>"));
        }
        header("Location:index.php");
        exit;
    }
    
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .enlinea {
            display: inline
        }

        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background-color: #CCC;
        }

        table img {
            height: 60px;
            width: 60px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Primer Login - Vista Admin</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_logueado["nombre"]; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <?php

    try {
        $consulta = "select * from usuarios where tipo <> 'admin'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr>
                <th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th><th width='80px'><form action='index.php' method='post'><button class='enlace' type='submit' name='btnInsertar'>+</button></form></th>
         </tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {

        echo "<tr>
                        <td><form action='index.php' method='post'><button class='enlace' type='submit' name='botonDetalle' title='Detalles del usuario' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</button></form></td>
                        <td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='" . $tupla["nombre"] . "'><button class='enlace' type='submit' name='botonBorrar' title='Borrar usuario' value='" . $tupla["id_usuario"] . "'><img src='images/error.png'></button></form></td>
                        <td><form action='index.php' method='post'><button class='enlace' type='submit' name='botonEditar' title='Editar usuario' value='" . $tupla["id_usuario"] . "'><img src='images/lapiz.png'></button></form></td>
            </tr>";
    }
    echo "</table>";
    if (isset($_POST["botonDetalle"])) {

        echo "<h3>Detalles del usuario con el id= " . $_POST["botonDetalle"] . "</h3>";

        try {
            $consulta = "select * from usuarios where id_usuario='" . $_POST["botonDetalle"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
        }

        if (mysqli_num_rows($resultado) > 0) {
            $datos_usuario = mysqli_fetch_assoc($resultado);


            echo "<p>
                <strong> Nombre: </strong>" . $datos_usuario["nombre"] . "<br>
                <strong> Usuario: </strong>" . $datos_usuario["usuario"] . "<br>
                <strong> Email: </strong>" . $datos_usuario["email"] . "<br>
                <strong> Tipo usuario: </strong>" . $datos_usuario["tipo"] . "<br>
                
                
        </p>";
        } else {
            echo "<p>El usuario seleccionado no se encuentra registrado en la base de datos</p>";
        }
        echo "<form action='index.php'><button type='submit'>Volver</button></form>";
    } else if (isset($_POST["botonBorrar"])) {

        echo "<p>Se dispone usted a borrar al usuario <strong>" . $_POST["nombre_usuario"] . "</strong></p>";
        echo "<form action='index.php' method='post'>
        <p>
        <button type='submit' name='btnContBorrar' value='" . $_POST["botonBorrar"] . "'>Continuar</button>
        <button type='submit'>Atrás</button>
        </p>
        </form>";
    } else if (isset($_POST["botonEditar"]) || isset($_POST["btnContEd  itar"])) {

        $id;
        if (isset($_POST["botonEditar"]))
            $id = $_POST["botonEditar"];
        else
            $id = $_POST["btnContEditar"];

        try {
            $consulta = "select * from usuarios where id_usuario ='" . $id . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
        }

        if (mysqli_num_rows($resultado) > 0) {

            $arr = mysqli_fetch_assoc($resultado);

    ?>
            <h2>Editando al ususario: <?php echo $arr["id_usuario"] ?></h2>
            <form action="index.php" method="post" enctype="multipart/form-data">

                <p>
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" id="name" maxlength="30" value="<?php echo $arr["nombre"] ?>">
                    <?php
                    if (isset($_POST["btnContEditar"]) && $error_nombre) {

                        if ($_POST["name"] == "") echo "<span class='error'>Campo vacío</span>";
                        else echo "<span class='error'>El tamaño debe ser menor que 30</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="usu">Ususario:</label>
                    <input type="text" name="usu" id="usu" maxlength="20" value="<?php echo $arr["usuario"] ?>">
                    <?php
                    if (isset($_POST["btnContEditar"]) && $error_usuario) {

                        if ($_POST["usu"] == "") echo "<span class='error'>Campo vacío</span>";
                        else if (strlen($_POST["usu"]) > 20) echo "<span class='error'>El tamaño debe ser menor que 20</span>";
                        else  echo "<span class='error'>Usuario repetido</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="pass">Contraseña: </label>
                    <input type="password" name="pass" id="pass" maxlength="15" placeholder="Editar Contraseña">
                    <?php
                    if (isset($_POST["btnContEditar"]) && $error_pass) {

                        echo "<span class='error'>El tamaño debe ser menor que 15</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" maxlength="50" value="<?php echo $arr["email"] ?>">
                    <?php
                    if (isset($_POST["btnContEditar"]) && $error_email) {

                        if ($_POST["email"] == "") echo "<span class='error'>Campo vacío</span>";
                        else if (strlen($_POST["pass"]) > 50) echo "<span class='error'>El tamaño debe ser menor que 50</span>";
                        else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) echo "<span class='error'>Email mal escrito</span>";
                        else echo "<span class='error'>Email repetido</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="admin">Admin</label>
                    <input type="radio" name="tipo" id="admin" value="admin">
                    <label for="normal">Normal</label>
                    <input type="radio" name="tipo" id="normal" value="normal">
                </p>
                <p>
                    <button type="submit" name="btnContEditar" value="<?php echo $id ?>">Continuar</button>
                    <button type="submit" name="volver">Volver</button>
                </p>
            </form>


    <?php
        } else {
            echo "<p>El usuario seleccionado no se encuentra registrado en la base de datos</p>";
        }
    }
    mysqli_free_result($resultado);
    ?>
</body>

</html>