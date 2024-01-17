<?php

 try {
    $consulta="select * from usuarios where lector=? and clave=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$_SESSION["usuario"],$_SESSION["clave"]]);
} catch (PDOException $e) {
    session_destroy();
    $sentencia = null;
    $conexion = null;
    die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
}

if($sentencia->rowCount()<=0)
{
    $sentencia=null;
    $conexion=null;
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:".$salto);
    exit;
}

$datos_usuario_logueado=$sentencia->fetch(PDO::FETCH_ASSOC);
$sentencia=null;

// Ahora control de inactividad

if(time()-$_SESSION["ultima_accion"]>MINUTOS_INACT*60)
{
    $conexion=null;
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha caducado";
    header("Location:".$salto);
    exit;
}

$_SESSION["ultima_accion"]=time();

?>