<?php
require "src/ctes_funciones.php";
if (isset($_POST["btnContBorrar"])) {

    try {
        //Realizar conexión
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("<h1>Primer CRUD</h1>", "<p>No ha podido conectarse a la a base de datos:" . $e->getMessage() . "</p>"));
    }

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

    echo"<p>Hola</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 1 CRUD</title>
    <style>
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
    <h1>Listado de los usuarios</h1>

    <?php
    try {
        //Realizar conexión
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No ha podido conectarse a la a base de datos:" . $e->getMessage() . "</p></body></html>");
    }



    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr>
                    <th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th>
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
    } else if (isset($_POST["botonEditar"])) {

        try {
            $consulta = "select * from usuarios where id_usuario ='" . $_POST["botonEditar"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
        }

        if (mysqli_num_rows($resultado) > 0) {



            $arr = mysqli_fetch_assoc($resultado);

    ?>
            <form action="index.php" method="post" enctype="multipart/form-data">

                <p>
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" id="name" maxlength="30" value="<?php if (isset($_POST["botonEditar"])) echo $arr["nombre"] ?>">
                    <?php
                    if (isset($_POST["btnContEditar"]) && $error_nombre) {

                        if ($_POST["name"] == "") echo "<span class='error'>Campo vacío</span>";
                        else echo "<span class='error'>El tamaño debe ser menor que 30</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="usu">Ususario:</label>
                    <input type="text" name="usu" id="usu" maxlength="20" value="<?php if (isset($_POST["botonEditar"])) echo $arr["usuario"] ?>">
                    <?php
                    if (isset($_POST["continuar"]) && $error_usuario) {

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
                    if (isset($_POST["continuar"]) && $error_pass) {

                        if ($_POST["pass"] == "") echo "<span class='error'>Campo vacío</span>";
                        else echo "<span class='error'>El tamaño debe ser menor que 15</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" maxlength="50" value="<?php if (isset($_POST["botonEditar"])) echo $arr["email"] ?>">
                    <?php
                    if (isset($_POST["continuar"]) && $error_email) {

                        if ($_POST["email"] == "") echo "<span class='error'>Campo vacío</span>";
                        else if (strlen($_POST["pass"]) > 50) echo "<span class='error'>El tamaño debe ser menor que 50</span>";
                        else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) echo "<span class='error'>Email mal escrito</span>";
                        else echo "<span class='error'>Email repetido</span>";
                    }
                    ?>
                </p>
                <p>
                    <button type="submit" name="btnContEditar">Continuar</button>
                    <button type="submit" name="volver">Volver</button>
                </p>
            </form>


    <?php
        } else {
            echo "<p>El usuario seleccionado no se encuentra registrado en la base de datos</p>";
        }
    } else {
        echo "<p><form action='usuario_nuevo.php' method='post' enctype='multipart/form-data'><button type='submit' name='insertar'>Inserta nuevo usuario</button></form></p>";
    }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>