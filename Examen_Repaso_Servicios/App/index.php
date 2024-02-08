<?php
session_name("Exam_horarios_prof");
session_start();
define("DIR_SERV", "http://localhost/Proyectos/Examen_Repaso_Servicios/servicios_rest");
define("MINUTOS", 10);
function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title,$body)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' .$body. '</body></html>';
    return $html;
}

if(isset($_POST["btnLogin"])){

    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";

    $error_form=$error_usuario || $error_clave;

    if(!$error_form){

        $url=DIR_SERV."/login";

        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);

        $respuesta=consumir_servicios_REST($url,"POST",$datos);
        $obj=json_decode($respuesta);
        if(!$obj){
            session_destroy();
            die(error_page("Error servicio","<p>Error consumiendo servicios rest".$url."</p>"));
        }
        if(isset($obj->error)){
            session_destroy();
            die(error_page("Error servicio","<p>Error consumiendo servicios rest".$obj->error."</p>"));
        }
        if(isset($obj->mensaje)){
            $error_usuario=true;
            session_destroy();
            die(error_page("Error servicio","<p>Error consumiendo servicios rest".$obj->mensaje."</p>"));
        }

        $_SESSION["usuario"]=$obj->usuario->usuario;
        $_SESSION["clave"]=$obj->usuario->clave;
        $_SESSION["token"]=$obj->token;
        $_SESSION["ultima_accion"]=time();

        header("Location:#");
        exit;
        
    }


}
if(isset($_SESSION["usuario"])){
    echo "Estoy Logeado";
}else{



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>
<form action="#" method="post">

    <p>
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario">
    </p>
    <p>
        <label for="clave">Clave</label>
        <input type="password" name="clave" id="clave">
    </p>
    <p>
        <button type="submit" name="btnLogin">Entrar</button>
    </p>

</form>
    
</body>
</html>
<?php
}
?>