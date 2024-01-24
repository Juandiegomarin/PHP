<?php
session_name("Crud_SW");
session_start();
define("DIR_SERV", "http://localhost/Proyectos/Practica1_SW/servicios_rest");

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

if (isset($_POST["btnContinuarInsertar"])) {

    $error_codigo = $_POST["codigo"] == "";
    if (!$error_codigo) {
        $url = DIR_SERV . "/repetido/producto/cod/" . urlencode($_POST["codigo"]);
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
        if (isset($obj->mensaje_error)) {
            echo "<p>" . $obj->mensaje_error . "</p>";
        }
        if ($obj->repetido) {
            $error_codigo = true;
        }
    }
    $error_nombre_corto = $_POST["nombre_corto"] == "";
    if (!$error_nombre_corto) {
        $url = DIR_SERV . "/repetido/producto/nombre_corto/" . urlencode($_POST["nombre_corto"]);
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
        if (isset($obj->mensaje_error)) {
            echo "<p>" . $obj->mensaje_error . "</p>";
        }
    }
    $error_pvp = $_POST["pvp"] == "" || !is_numeric($_POST["pvp"]) || $_POST["pvp"] <= 0;


    $error_form = $error_codigo || $error_nombre_corto || $error_pvp;
    if (!$error_form) {

        $url = DIR_SERV . "/producto/insertar";

        $datos["cod"] = $_POST["codigo"];
        $datos["nombre"] = $_POST["nombre"];
        $datos["nombre_corto"] = $_POST["nombre_corto"];
        $datos["descripcion"] = $_POST["descripcion"];
        $datos["pvp"] = $_POST["pvp"];
        $datos["familia"] = $_POST["familia"];

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
        if (isset($obj->mensaje_error)) {
            echo "<p>" . $obj->mensaje_error . "</p>";
        }

        $_SESSION["mensaje"] = $obj->mensaje;
        header("Location:index.php");
        exit;
    }
}
if (isset($_POST["btnContEditar"])) {



    $error_nombre_corto = false;

    if (!$error_nombre_corto) {
        $url = DIR_SERV . "/repetidoEditando/producto/nombre_corto/" . urlencode($_POST["nombre_corto"]) . "/cod/" . urlencode($_POST["btnContEditar"]) . "";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
        if (isset($obj->mensaje_error)) {
            echo "<p>" . $obj->mensaje_error . "</p>";
        }
        if ($obj->repetido) {
            $error_nombre_corto = true;
        }
    }
    $error_pvp = !is_numeric($_POST["pvp"]) || $_POST["pvp"] <= 0;
    $error_form = $error_nombre_corto || $error_pvp;
    if (!$error_form) {

        $url = DIR_SERV . "/producto/actualizar/" . urlencode($_POST["btnContEditar"]). "";

        $datos["cod"] = $_POST["btnContEditar"];
        $datos["nombre"] = $_POST["nombre"];
        $datos["nombre_corto"] = $_POST["nombre_corto"];
        $datos["descripcion"] = $_POST["descripcion"];
        $datos["pvp"] = $_POST["pvp"];
        $datos["familia"] = $_POST["familia"];

        $respuesta = consumir_servicios_REST($url, "PUT", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
        if (isset($obj->mensaje_error)) {
            echo "<p>" . $obj->mensaje_error . "</p>";
        }

        $_SESSION["mensaje"] = $obj->mensaje;
        header("Location:index.php");
        exit;
    }
}
if(isset($_POST["btnContBorrar"])){

    $url = DIR_SERV . "/producto/borrar/" .urlencode($_POST["btnContBorrar"])."";
    $respuesta = consumir_servicios_REST($url, "DELETE");
        $obj = json_decode($respuesta);
        if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
        if (isset($obj->mensaje_error)) {
            echo "<p>" . $obj->mensaje_error . "</p>";
        }

        $_SESSION["mensaje"] = $obj->mensaje;
        header("Location:index.php");
        exit;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <style>
        .centrado {
            text-align: center;
        }

        table,
        td,
        th,
        tr {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        table {
            width: 60%;
            align-self: center;
        }

        .enlace {
            cursor: pointer;
            background: none;
            color: blue;
            border: none;
            text-decoration: underline;
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
    <h1 class="centrado">Listado de productos</h1>
    <?php

    if (isset($_POST["btnInsertar"]) || isset($_POST["btnContinuarInsertar"])) {

    ?>
        <h2>Creando nuevo producto</h2>
        <form action="index.php" method="post">

            <p>
                <label for="codigo">Codigo:</label>
                <input type="text" name='codigo' id='codigo' value="<?php if (isset($_POST["codigo"])) echo $_POST["codigo"] ?>" />
                <?php
                if (isset($_POST["codigo"]) && $error_codigo) {
                    if ($_POST["codigo"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } else {
                        echo "<span class='error'>Codigo repetido</span>";
                    }
                }
                ?>
            </p>

            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name='nombre' id='nombre' value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>" />
            </p>

            <p>
                <label for="nombre_corto">Nombre Corto:</label>
                <input type="text" name='nombre_corto' id='nombre_corto' value="<?php if (isset($_POST["nombre_corto"])) echo $_POST["nombre_corto"] ?>" />
                <?php
                if (isset($_POST["nombre_corto"]) && $error_nombre_corto) {
                    if ($_POST["nombre_corto"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } else {
                        echo "<span class='error'>Nombre corto repetido</span>";
                    }
                }
                ?>
            </p>

            <p>
                <label for="descripcion">Descripcion:</label>
                <textarea name="descripcion" id="descripcion" cols="30" rows="3" value="<?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"] ?>"></textarea>
            </p>
            <p>
                <label for="pvp">PVP:</label>
                <input type="text" name='pvp' id='pvp' value="<?php if (isset($_POST["pvp"])) echo $_POST["pvp"] ?>">
                <?php
                if (isset($_POST["pvp"]) && $error_pvp) {
                    if ($_POST["pvp"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } elseif ($_POST["pvp"] <= 0) {
                        echo "<span class='error'>No se permiten valores menores o iguales a 0</span>";
                    } else {
                        echo "<span class='error'>Valor no numerico</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="fam">Familia</label>
                <select name="familia" id="fam">


                    <?php
                    $url = DIR_SERV . "/familias";
                    $respuesta = consumir_servicios_REST($url, "GET");
                    $obj = json_decode($respuesta);
                    if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
                    if (isset($obj->mensaje_error)) {
                        echo "<p>" . $obj->mensaje_error . "</p>";
                    }
                    foreach ($obj->familias as $familia) {
                        if ($familia->cod == $_POST["familia"]) {
                            echo "<option values='" . $familia->cod . "' selected>" . $familia->cod . "</option>";
                        } else {
                            echo "<option values='" . $familia->cod . "'>" . $familia->cod . "</option>";
                        }
                    }

                    ?>
                </select>
            </p>
            <p>
                <button type="submit" name='btnContinuarInsertar'>Continuar</button>
                <button type="submit">Volver</button>
            </p>


        </form>
    <?php
    }
    if (isset($_POST["btnEditar"])) {
    ?>
        <h2>Editando producot con id <?php echo $_POST["btnEditar"] ?></h2>
        <form action="index.php" method="post">
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name='nombre' id='nombre' value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"] ?>" />
            </p>

            <p>
                <label for="nombre_corto">Nombre Corto:</label>
                <input type="text" name='nombre_corto' id='nombre_corto' value="<?php if (isset($_POST["nombre_corto"])) echo $_POST["nombre_corto"] ?>" />
                <?php
                if (isset($_POST["nombre_corto"]) && $error_nombre_corto) {
                    if ($_POST["nombre_corto"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } else {
                        echo "<span class='error'>Nombre corto repetido</span>";
                    }
                }
                ?>
            </p>

            <p>
                <label for="descripcion">Descripcion:</label>
                <textarea name="descripcion" id="descripcion" cols="30" rows="3" value="<?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"] ?>"></textarea>
            </p>
            <p>
                <label for="pvp">PVP:</label>
                <input type="text" name='pvp' id='pvp' value="<?php if (isset($_POST["pvp"])) echo $_POST["pvp"] ?>">
                <?php
                if (isset($_POST["pvp"]) && $error_pvp) {
                    if ($_POST["pvp"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } elseif ($_POST["pvp"] <= 0) {
                        echo "<span class='error'>No se permiten valores menores o iguales a 0</span>";
                    } else {
                        echo "<span class='error'>Valor no numerico</span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="fam">Familia</label>
                <select name="familia" id="fam">


                    <?php
                    $url = DIR_SERV . "/familias";
                    $respuesta = consumir_servicios_REST($url, "GET");
                    $obj = json_decode($respuesta);
                    if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
                    if (isset($obj->mensaje_error)) {
                        echo "<p>" . $obj->mensaje_error . "</p>";
                    }
                    foreach ($obj->familias as $familia) {
                        if ($familia->cod == $_POST["familia"]) {
                            echo "<option values='" . $familia->cod . "' selected>" . $familia->cod . "</option>";
                        } else {
                            echo "<option values='" . $familia->cod . "'>" . $familia->cod . "</option>";
                        }
                    }

                    ?>
                </select>
            </p>
            <p>
                <button type="submit" name='btnContEditar' value="<?php echo $_POST["btnEditar"] ?>">Continuar</button>
                <button type="submit">Volver</button>
            </p>


        </form>



    <?php
    }
    if (isset($_POST["btnBorrar"])) {

        echo "<h3>¿Quieres borrar el producto con id: " . $_POST["btnBorrar"] . "?</h3>";
        echo "<form method='post' action='#'> <button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Si</button><button type='submit'>No</button></form>";
    }

    if (isset($_POST["btnDetalle"])) {

        $url = DIR_SERV . "/producto/" . $_POST["btnDetalle"];
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
        if (isset($obj->mensaje_error)) {
            echo "<p>" . $obj->mensaje_error . "</p>";
        }

        if (isset($obj->mensaje)) {
            echo "<p>" . $obj->mensaje . "</p>";
        } else {
            echo "<h1>Detalle del producto con código " . $obj->producto->cod . "</h1>";
            echo "<p><strong>Codigo producto: </strong>" . $obj->producto->cod . "</p>";
            echo "<p><strong>Nombre: </strong>" . $obj->producto->nombre . "</p>";
            echo "<p><strong>Nombre Corto: </strong>" . $obj->producto->nombre_corto . "</p>";
            echo "<p><strong>Descripción: </strong>" . $obj->producto->descripcion . "</p>";
            echo "<p><strong>PVP: </strong>" . $obj->producto->PVP . "</p>";
            echo "<p><strong>Familia: </strong>" . $obj->producto->familia . "</p>";
        }

        echo "<form method='post' action='#'> <button type='submit'>Volver</button></form>";
        echo "<br>";
        echo "<br>";
    }

    if (isset($_SESSION["mensaje"])) {
        echo "<p class='azul'>" . $_SESSION["mensaje"] . "</p>";
        unset($_SESSION["mensaje"]);
    }


    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
    if (isset($obj->mensaje_error)) {
        echo "<p>" . $obj->mensaje_error . "</p>";
    }

    echo "<table>";

    echo "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><form method='post' action='index.php'><button class='enlace' name='btnInsertar'>Productos+</button></form></th></tr>";
    foreach ($obj->productos as $producto) {
        echo "<tr><td><form method='post' action='index.php'><button class='enlace' value='" . $producto->cod . "' name='btnDetalle'>" . $producto->cod . "</button></form></td><td>" . $producto->nombre_corto . "</td><td>" . $producto->PVP . "</td><td><form method='post' action='index.php'><button class='enlace' value='" . $producto->cod . "'name='btnBorrar'>Borrar</button>-<button class='enlace' value='" . $producto->cod . "' name='btnEditar'>Editar</button></form></td></tr>";
    }

    echo "</table>";
    ?>

</body>

</html>