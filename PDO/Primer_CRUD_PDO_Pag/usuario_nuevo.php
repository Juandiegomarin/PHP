<?php

require "src/ctes_funciones.php";

if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContInsertar"]) )
{
    if(isset($_POST["btnContInsertar"])) // compruebo errores
    {
        $error_nombre=$_POST["nombre"]==""|| strlen($_POST["nombre"])>30;
        $error_usuario=$_POST["usuario"]==""|| strlen($_POST["usuario"])>20;
        if(!$error_usuario)
        {
            try
            {
                $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            }
            catch(PDOException $e)
            {
                die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
            }
           

            $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
            
            if(is_string($error_usuario))
            {
                $conexion=null;
                die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido realizar la consulta: ".$error_usuario."</p>"));
            }
                
        }

        $error_clave=$_POST["clave"]=="" || strlen($_POST["clave"])>15;
        $error_email=$_POST["email"]=="" || strlen($_POST["email"])>50 || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
        if(!$error_email)
        {
            if(!isset($conexion))
            {
                try
                {
                    $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                }
                catch(PDOException $e)
                {
                    die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
                }
            }
            $error_email=repetido($conexion,"usuarios","email",$_POST["email"]);
            
            if(is_string($error_email))
            {
                $conexion=null;
                die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No ha podido realizarse la consulta: ".$error_email."</p>"));
            }
                

            
        }
        $error_form=$error_nombre||$error_usuario||$error_clave||$error_email;

        if(!$error_form)
        {
            
            try{
                $consulta="insert into usuarios (nombre,usuario,clave,email) values (?,?,?,?)";
                $clave_encriptada=md5($_POST["clave"]);
                $sentencia=$conexion->prepare($consulta);
                $sentencia->execute([$_POST["nombre"], $_POST["usuario"],$clave_encriptada,$_POST["email"]]);
            }
            catch(PDOException $e)
            {
                $sentencia=null;
                $conexion=null;
                die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>"));
            }

            $sentencia=null;
            $conexion=null;

            
            session_name("primer_CRUD");
            session_start();
            $_SESSION["mensaje"]="El usuario ha sido creado con éxito";
            header("Location:index.php");
            exit;
            
        }

        //Por aquí continuo sólo si hay errores en el formulario

        if(isset($conexion))
           $conexion=null;
        
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1º CRUD</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Práctica 1º CRUD</h1>
    <h2>Usuario Nuevo</h2>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php  if(isset($_POST["nombre"])) echo $_POST["nombre"];?>">
            <?php
            if(isset($_POST["btnContInsertar"]) && $error_nombre)
            {
                if($_POST["nombre"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Has tecleado más de 30 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php  if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" >
            <?php
            if(isset($_POST["btnContInsertar"]) && $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                elseif(strlen($_POST["usuario"])>20)
                    echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
                else
                    echo "<span class='error'> Usuario repetido</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" maxlength="15" id="clave" >
            <?php
            if(isset($_POST["btnContInsertar"]) && $error_clave)
            {
                if($_POST["clave"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" maxlength="50" value="<?php  if(isset($_POST["email"])) echo $_POST["email"];?>">
            <?php
            if(isset($_POST["btnContInsertar"]) && $error_email)
            {
                if($_POST["email"]=="")
                    echo "<span class='error'> Campo vacío</span>";
                elseif(strlen($_POST["email"])>50)
                    echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
                elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'> Email sintáxticamente incorrecto</span>";
                else
                    echo "<span class='error'> Email repetido</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnContInsertar">Continuar</button> 
            <button type="submit">Volver</button> 
        </p>
    </form>
</body>
</html>
<?php
}
else
{
    header("Location:index.php");
    exit;
}
?>