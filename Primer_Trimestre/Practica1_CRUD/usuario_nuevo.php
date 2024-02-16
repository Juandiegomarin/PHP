<?php
require "src/ctes_funciones.php";
if (isset($_POST["insertar"]) || isset($_POST["continuar"])) {
    if (isset($_POST["continuar"])) {


        $error_nombre = $_POST["name"] == "" || strlen($_POST["name"]) > 30;
        $error_usuario = $_POST["usu"] == "" || strlen($_POST["usu"]) > 20;
        if (!$error_usuario) {

            try {
                //Realizar conexión
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro2");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("<h1>Primer CRUD</h1>", "<p>No ha podido conectarse a la a base de datos:" . $e->getMessage() . "</p>"));
            }

            
            

            $error_usuario = repetido($conexion,"usuarios","usuario",$_POST["usu"]);
            if(is_string($error_usuario)){
                
                die($error_usuario);
            }
            
        }
        $error_pass = $_POST["pass"] == "" || strlen($_POST["pass"]) > 15;
        $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || strlen($_POST["email"]) > 50;
        if (!$error_email) {

            if (!isset($conexion)) {

                try {
                    //Realizar conexión
                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro2");
                    mysqli_set_charset($conexion, "utf8");
                } catch (Exception $e) {
                    die(error_page("<h1>Primer CRUD</h1>", "<p>No ha podido conectarse a la a base de datos:" . $e->getMessage() . "</p>"));
                }
            }
            

            $error_email = repetido($conexion,"usuarios","email",$_POST["email"]);
            if(is_string($error_email)){
                
                die($error_email);
            }
            
        }

        $error_form = $error_nombre || $error_usuario || $error_pass || $error_email;

        if (!$error_form) {
            try{
            $consulta ="insert into usuarios (nombre,usuario,clave,email) values ('".$_POST["name"]."','".$_POST["usu"]."','".md5($_POST["pass"])."','".$_POST["email"]."')";
            mysqli_query($conexion,$consulta);
            }catch(Exception $e){
                mysqli_close($conexion);
                die(error_page("<h1>Primer CRUD</h1>", "<p>No se ha podido realizar la consulta:" . $e->getMessage() . "</p>"));

            }
            
            mysqli_close($conexion);


            header("Location:index.php");
            exit;
        }
        if (isset($conexion)) {
            mysqli_close($conexion);
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuario nuevo</title>
        <style>
            .error {
                color: red;
            }
        </style>
    </head>

    <body>
        <h1>Nuevo Usuario</h1>

        <form action="usuario_nuevo.php" method="post" enctype="multipart/form-data">

            <p>
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" maxlength="30" value="<?php if (isset($_POST["name"])) echo $_POST["name"] ?>">
                <?php
                if (isset($_POST["continuar"]) && $error_nombre) {

                    if ($_POST["name"] == "") echo "<span class='error'>Campo vacío</span>";
                    else echo "<span class='error'>El tamaño debe ser menor que 30</span>";
                }
                ?>
            </p>
            <p>
                <label for="usu">Ususario:</label>
                <input type="text" name="usu" id="usu" maxlength="20" value="<?php if (isset($_POST["usu"])) echo $_POST["usu"] ?>">
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
                <input type="password" name="pass" id="pass" maxlength="15" value="<?php if (isset($_POST["pass"])) echo $_POST["pass"] ?>">
                <?php
                if (isset($_POST["continuar"]) && $error_pass) {

                    if ($_POST["pass"] == "") echo "<span class='error'>Campo vacío</span>";
                    else echo "<span class='error'>El tamaño debe ser menor que 15</span>";
                }
                ?>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" maxlength="50" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
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
                <button type="submit" name="continuar">Continuar</button>
                <button type="submit" name="volver">Volver</button>
            </p>
        </form>

    </body>

    </html>
<?php
} else {
    header("Location:index.php");
    exit;
}
?>