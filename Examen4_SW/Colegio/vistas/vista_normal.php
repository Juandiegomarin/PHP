<?php
$url=DIR_SERV."/notasAlumno/".$datos_usuario_log->cod_usu;
$respuesta=consumir_servicios_REST($url,"GET",$datos);
$obj=json_decode($respuesta);
if(!$obj)
{
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
}
if(isset($obj->error))
{
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
}
if(isset($obj->no_auth))
{
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if(isset($obj->mensaje))
{
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4</title>
    <style>
        .enlace{
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
        .enLinea{
            display: inline;
        }
        table,td,th,tr{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th{
            background-color: lightgrey;
        }
    </style>
</head>
<body>

<h1>Notas de los alumnos</h1>
<div>Bienvenido <strong><?php echo $datos_usuario_log->usuario?></strong>
<form action="index.php" method="post" class="enLinea"><button type="submit" name="btnSalir" class="enlace">Salir</button></form>
</div>
    
<h2>Notas del alumno <?php echo $datos_usuario_log->nombre?></h2>

<?php
echo "<table>";
echo "<tr><th>Asignatura</th><th>Nota</th></tr>";
if(count($obj->notas)!=0){
    foreach ($obj->notas as $nota) {
        echo"<tr><td>".$nota->denominacion."</td><td>".$nota->nota."</td></tr>";
    }
}
echo "</table>";
?>
</body>
</html>