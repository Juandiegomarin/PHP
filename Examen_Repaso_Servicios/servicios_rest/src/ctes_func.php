<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_horarios_exam2");


function login($datos)
{


    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {

        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("api_profes");
        session_start();

        $_SESSION["usuario"] = $datos[0];
        $_SESSION["clave"] = $datos[1];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["token"] = session_id();

        $conexion = null;
        $sentencia = null;
    } else {
        $respuesta["mensaje"] = "Este usuario no se encuentra en la base de datos";
    }
    return $respuesta;
}

function logeado($usuario, $clave)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }



    if ($sentencia->rowCount() > 0) {

        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";


    $conexion = null;
    $sentencia = null;

    return $respuesta;
}
function obtener_grupos($id_usuario, $dia, $hora)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }

    try {
        $consulta = "select grupo from horario_lectivo where usuario=? and dia=? and hora=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario, $dia, $hora]);
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }



    if ($sentencia->rowCount() > 0) {

        $respuesta["grupo"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else
        $respuesta["mensaje"] = "No esta en la base de datos";

    $conexion = null;
    $sentencia = null;


    return $respuesta;
}

function obtener_nombre_grupo($id_grupo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }

    try {
        $consulta = "select nombre from grupos where id_grupo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_grupo]);
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }



    if ($sentencia->rowCount() > 0) {

        $respuesta["nombre"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else
        $respuesta["mensaje"] = "No esta en la base de datos";

    $conexion = null;
    $sentencia = null;


    return $respuesta;
}
