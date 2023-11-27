<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>
    <style>


    </style>
</head>
<body>

<h1>Notas de los Alumnos</h1>

<?php
//abro conexion
try {
    $conexion= mysqli_connect("localhost","jose","josefa","bd_exam_colegio");
    mysqli_set_charset($conexion,"utf8");

} catch (Exception $e) {
    die("<p>No se ha podido acceder a la : ".$e->getMessage()."</p>");
}

//consulta para traer a los alumnos
try {
    $consulta="select * from alumnos";
    $resultado=mysqli_query($conexion,$consulta);
} catch (Exception $e) {
    mysqli_close($conexion);
    die("<p>No se ha podido hacer la consulta : ".$e->getMessage()."</p>");
}

if(mysqli_num_rows($resultado)>0){


echo "<form action='index.php' method='post' enctype='multipart/form-data'>";
echo"<label for='alumno'>Seleccione un alumno: <label>";
echo "<select name='alumno' id='alumno'>";
while($fila=mysqli_fetch_assoc($resultado)){

    if(isset($_POST["alumno"]) && $_POST["alumno"]==$fila["cod_alu"]){
    echo"<option selected value='".$fila["cod_alu"]."'>".$fila["nombre"]."</option>";
    $nombre=$fila["nombre"];
    }else{
        echo"<option value='".$fila["cod_alu"]."'>".$fila["nombre"]."</option>";
    }
}
echo "</select>";
echo"<button type='submit' name='btnVerNotas'>Ver notas</button></form>";
}else{
    echo"<p>No hay alumnos insertados en la bease de datos todavía</p>";
}


if(isset($_POST["btnVerNotas"])){
    echo"<h2>Notas del alumno ". $nombre."</h2>";
   
//consulta para traer las notas de un alomno
try {
    $consulta="select * from notas where cod_alu=".$_POST["alumno"]."";
    $resultado=mysqli_query($conexion,$consulta);
} catch (Exception $e) {
    mysqli_close($conexion);
    die("<p>No se ha podido hacer la consulta : ".$e->getMessage()."</p>");
}


}


?>
    
</body>
</html>