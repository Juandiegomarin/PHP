<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_tienda");

function error_page($title, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '
        
    </body>
    </html>';
    return $page;
}
function productos()
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "select * from producto";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }

    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}

function producto($cod)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "select * from producto where cod=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }

    
    if ($sentencia->rowCount() > 0) {
        $respuesta["producto"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "No hay ningun producto con este codigo en la base de datos";
    }
    $sentencia = null;
    $conexion = null;

    return $respuesta;
}

function insertar($cod, $nombre, $nombre_corto, $descripcion, $pvp, $familia)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "insert into producto (cod,nombre,nombre_corto,descripcion,PVP,familia) values (?,?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod, $nombre, $nombre_corto, $descripcion, $pvp, $familia]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    $sentencia = null;
    $conexion = null;
    $respuesta["mensaje"] = "El producto " . $nombre_corto . " insertado correctamente";
    return $respuesta;
};

function actualizar($cod, $nombre, $nombre_corto, $descripcion, $pvp, $familia)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "update producto set nombre = ?,nombre_corto = ?, descripcion = ?,PVP= ?,familia = ? where cod = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$nombre, $nombre_corto, $descripcion, $pvp, $familia, $cod]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    $sentencia = null;
    $conexion = null;
    $respuesta["mensaje"] = "El producto " . $nombre_corto . " actualizado correctamente";
    return $respuesta;
};

function borrar($cod)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "delete from producto where cod = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    $sentencia = null;
    $conexion = null;
    $respuesta["mensaje"] = "El producto " . $cod . " borrado correctamente";
    return $respuesta;
};

function familias()
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "select * from familia";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }

    $respuesta["familias"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}

function repetido($tabla, $columna, $valor)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "select * from " . $tabla . " where " . $columna . " = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }

    if ($sentencia->rowCount() >0)
        $respuesta["repetido"] = true;
    else {
        $respuesta["repetido"] = false;
    }

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}
function repetidoEditando($tabla, $columna, $valor,$columna_id,$valor_id)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }
    try {
        $consulta = "select * from " . $tabla . " where " . $columna . " = ? AND ".$columna_id." <> ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor,$valor_id]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }

    
        $respuesta["repetido"] = ($sentencia->rowCount())>0;
   

    $sentencia = null;
    $conexion = null;

    return $respuesta;
}
function login($usuario,$clave){

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>";
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["mensaje_error"] = "Error en la consulta: " . $e->getMessage() . "</p>";
        return $respuesta;
    }

    if ($sentencia->rowCount() >0)
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la base de datos";
    }
    return $respuesta;
}
?>