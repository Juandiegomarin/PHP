<?php
require "config_bd.php";


function login($lector, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {

        session_name("Examen_SW_22_23");
        session_start();
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        $respuesta["api_sesion"] = session_id();

        $_SESSION["usuario"] = $lector;
        $_SESSION["clave"] = $clave;
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
    } else
        $respuesta["mensaje"] = "El usuario no se encuentra en la BD";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function logeado($usuario,$clave)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="select * from usuarios where lector=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    if($sentencia->rowCount()>0){
      
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);

    }else
        $respuesta["mensaje"]="El usuario no se encuentra en la BD";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}
function insertar_libro($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="insert into libros (referencia,titulo,autor,descripcion,precio) values (?,?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

 
      //  $respuesta["ult_id"]=$conexion->lastInsertId();
      $respuesta["mensaje"]="Libro con id ".$datos[0]." insertado con exito";
  
    $sentencia=null;
    $conexion=null;
    return $respuesta;

}
function repetido($tabla,$columna,$valor,$columna_id=null,$valor_id=null)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        if(isset($columna_id))
        {
            $consulta="select * from ".$tabla." where ".$columna."=? AND ".$columna_id."<>?";
            $datos=[$valor,$valor_id];
        }
        else
        {
            $consulta="select * from ".$tabla." where ".$columna."=?";
            $datos=[$valor];
        }
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    $respuesta["repetido"]=($sentencia->rowCount())>0;
    $sentencia=null;
    $conexion=null;
    return $respuesta;

}
function libros()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "select * from libros";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);



    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
function obtener_libro($referencia)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
    }
    try {
        $consulta = "select * from libros where referencia=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$referencia]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "No se ha podido realizar la consulta: " . $e->getMessage());
    }

    if($sentencia->rowCount()>0){
        $respuesta["libro"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    }else{
        $respuesta["mensaje"]="No se ha obtenido ningun libro con esta referencia";
    }
    



    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
/*function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}
*/
/*
function conexion_mysqli()
{
  
    try
    {
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    }
    catch(Exception $e)
    {
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}*/
