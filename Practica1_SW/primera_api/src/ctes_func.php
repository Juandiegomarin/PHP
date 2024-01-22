<?php

function insertar($cod, $nombre, $nombre_corto, $descripcion, $PVP, $familia)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "insert into producto where cod = ?,nombre = ?,nombre_corto = ?,descripcion = ?,PVP = ?,familia = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod, $nombre, $nombre_corto, $descripcion, $PVP, $familia]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    $sentencia = null;
    $conexion = null;
    $respuesta["mensaje"] = "Producto insertado con exito";
    return $respuesta;
};
