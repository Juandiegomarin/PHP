<?php
session_name("examen3_23_24");
session_start();

require "../src/funct_ctes.php";

if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:../index.php");
    exit;
}



if(isset($_SESSION["usuario"]))
{
    $salto="../index.php";

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        session_destroy();
    }

    require "../src/seguridad.php";
    
    if($datos_usuario_logueado["tipo"]=="admin")
    {
        require "../vistas/vista_admin.php";
    }
    else
    {
        header("Location:../index.php");
        exit;
    }
}
else
{
    header("Location:../index.php");
    exit();
}