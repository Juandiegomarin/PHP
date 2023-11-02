<?php
if(isset($_POST["insertar"]) || isset($_POST["continuar"])){
    if(isset($_POST["continuar"])){


        $error_nombre=$_POST["name"]=="";
        $error_usuario=$_POST["usu"]=="";
        $error_pass=$_POST["pass"]=="";
        $error_email=$_POST["email"]=="" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);

        $error_form=$error_nombre||$error_usuario||$error_pass||$error_email;
        if(!$error_form){
            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario nuevo</title>
</head>
<body>
    <h1>Nuevo Usuario</h1>

    <form action="usuario_nuevo.php" method="post" enctype="multipart/form-data">

    <p>
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" maxlength="30">
    </p>
    <p>
        <label for="usu">Ususario:</label>
        <input type="text" name="usu" id="usu" maxlength="20">
    </p>
    <p>
        <label for="pass">Contrasña: </label>
        <input type="password" name="pass" id="pass" maxlength="15">
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" maxlength="50">
    </p>
    <p>
        <button type="submit" name="continuar">Continuar</button>
        <button type="submit" name="volver">Volver</button>
    </p>
    </form>
    
</body>
</html>
<?php
}else{
    header("Location:index.php");
    exit;
}
?>