<?php
session_name("Examen_17_18");
session_start();

if (isset($_POST["btnRegistrar"])|| isset($_POST["btnContRegistrar"])) {

    if(isset($_POST["btnContRegistrar"])){

        // errores
        $error_nombre=$_POST["nombre"]=""; 
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
<h1>VideoClub</h1>

<form action="usuario_nuevo.php" method="post">

    <p>
        <label for="nombre">Nombre de usuario:</label>
        <input type="text" name="nombre" id="nombre">
    </p>
    <p>
        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" id="pass">
    </p>
    <p>
        <label for="pass2">Repita la contraseña:</label>
        <input type="password" name="pass2" id="pass2">
    </p>
    <p>
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni">
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
    </p>
    <p>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono">
    </p>
    <p>
        <button type="submit" formaction="index.php">Volver</button>
        <button type="submit" name="btnContRegistrar">Continuar</button>
    </p>


</form>
    
</body>
</html>


<?php
}

?>