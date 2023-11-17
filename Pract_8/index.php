<?php
echo"<h1>Practica 8</h1>";
if(isset($_POST["botonDetalle"])){

try {
    //Realizar conexión
    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_cv");
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die("<p>No ha podido conectarse a la a base de datos:" . $e->getMessage() . "</p></body></html>");
}



try {
    $consulta = "select * from usuarios where id_usuario='".$_POST["botonDetalle"]."'";
    $resultado = mysqli_query($conexion, $consulta);
    mysqli_close($conexion);
} catch (Exception $e) {
    mysqli_close($conexion);
    die("<p>No ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
}

    $detalle_usuario=mysqli_fetch_assoc($resultado);
    echo "<h2>Detalles del usuario:</h2>";
    echo "<p><span class='negrita'>Usuario: </span>".$detalle_usuario["usuario"]."</p>";
    echo "<p><span class='negrita'>Nombre: </span>".$detalle_usuario["nombre"]."</p>";
    echo "<p><span class='negrita'>Dni: </span>".$detalle_usuario["dni"]."</p>";
    echo "<p><span class='negrita'>Sexo: </span>".$detalle_usuario["sexo"]."</p>";
    echo "<p><span class='negrita'>Foto: </span><br><img src=img/".$detalle_usuario["foto"]." width='100px'>'</p>";

    echo "<form><button type='submit'>Volver</button></form>";
}
if(isset($_POST["botonInsertar"])){
?>
<h2>Agregar nuevo usuario</h2>
<form action="index.php" method='post' enctype="multipart/form-data">

    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre..." maxlength="50"><br>
    <label for="usuario">Usuario:</label><br>
    <input type="text" name="usuario" id="usuario" placeholder="Usuario..." maxlength="50"><br>
    <label for="pass">Contraseña:</label><br>
    <input type="password" name="pass" id="pass" placeholder="Contraseña..." maxlength="15"><br>
    <label for="dni">DNI:</label><br>
    <input type="text" name="dni" id="dni" placeholder="DNI..."maxlength="9"><br>
    <label for="sexo">Sexo</label><br>
    <input type="radio" name="sexo" id="hombre" value="hombre">
    <label for="hombre">Hombre</label><br>
    <input type="radio" name="sexo" id="mujer" value="mujer">
    <label for="mujer">Mujer</label>
    <p><label for="foto">Incluir mi foto Max(500KB)</label><input type="file" name="foto" id="foto"></p>
    




</form>

    
<?php

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 8</title>
    <style>
        .negrita{
            font-weight: bold;
        }
        table,
        td,
        th {
            border: 1px solid black;
        }
        th,td{
            width: 10rem;        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
        .azul{
            color: blue;
        }
        #medio{
            margin-top:20px
        }
    </style>
</head>

<body>


    <?php
    try {
        //Realizar conexión
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_cv");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No ha podido conectarse a la a base de datos:" . $e->getMessage() . "</p></body></html>");
    }



    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No ha podido realizar la consulta:" . $e->getMessage() . "</p></body></html>");
    }
    
    
    
    echo " <h2>Listado de usuarios</h2> ";
    echo " <table>";
    echo "<tr>";
    echo "<td>#</td>";
    echo "<th>Foto</th>";
    echo "<th>Nombre</th>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='botonInsertar' id='medio'>Usuario +</button></form></td>";
    echo "<tr>";
    while($arr = mysqli_fetch_assoc($resultado)) { 
        echo "<tr>";
        echo "<td>".$arr["id_usuario"]."</td>";
        if($arr['foto']=="no_imagen.jpg")
        echo "<td><img src='img/no_imagen.jpg' title='Sin imagen' width='100px'></td>";
        else
        echo "<td>".$arr["foto"]."</td>";
        
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='botonDetalle' value='".$arr["id_usuario"]."'>".$arr['nombre']."</button></form></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='botonBorrar'>Borrar</button><span class='azul'>-</span><button class='enlace' type='submit' name='botonEditar'>Editar</button></form></td>";
        echo "</tr>";
    }

    echo " </table>";
    ?>
</body>

</html>