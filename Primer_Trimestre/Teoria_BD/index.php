<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría BD</title>
    <style>
        table,th,td{ border: 1px solid black;}
        table{border-collapse: collapse; width: 80%; margin: 0 auto; text-align: center;}
        th{background-color: grey;}
    </style>
</head>
<body>
        <?php
        try {   
                 //Realizar conexión
                 $conexion=mysqli_connect("localhost","jose","josefa","bd_teoria");
                 mysqli_set_charset($conexion,"utf8");
        } catch (Exception $e) {
            die ("<p>No ha podido conectarse a la a base de datos:".$e->getMessage()."</p></body></html>");
        }

        //consulta que vamos a realizar
        $consulta="select * from t_alumnos";

        try {
            //comprobar que la consulta es valida
            $resultado=mysqli_query($conexion,$consulta);
        } catch (Exception $e) {

            //cerramos conexion si nos equivocamos
            mysqli_close($conexion);
            die("<p>Imposible realizar la consulta:".$e->getMessage()."</p></body></html>");
        }

        //obtener numero de filas ede la tabla
        $n_tuplas=mysqli_num_rows($resultado);
        echo"<p>El número de tuplas obtenidas han sido: ".$n_tuplas."</p>";

        //obtener fila en array asociativo
        $fila=mysqli_fetch_assoc($resultado);
        echo"<p>El primer alumno obtenido tiene el nombre de: ".$fila["nombre"]."</p>";

        //obtener fila en array escalar
        $fila=mysqli_fetch_row($resultado);
        echo"<p>El segundo alumno obtenido tiene el nombre de: ".$fila[1]."</p>";

        //obtener fila en array escalar/asociativo
        $fila=mysqli_fetch_array($resultado);
        echo"<p>El tercer alumno obtenido tiene el nombre de: ".$fila[1]."</p>";
        echo"<p>El tercer alumno obtenido tiene el nombre de: ".$fila["nombre"]."</p>";

        mysqli_data_seek($resultado,0);
        //obtener fila en array con objetos
        $fila=mysqli_fetch_object($resultado);
        echo"<p>El x alumno obtenido tiene el nombre de: ".$fila->nombre."</p>";

        //Recorrer filas de una tabla
        mysqli_data_seek($resultado,0);//Volver al inicio
        echo"<table>";
                echo"<tr><th>Código</th><th>Nombre</th><th>Teléfono</th><th>CP</th></tr>";
                while($fila=mysqli_fetch_assoc($resultado)){

                    echo"<tr>";
                                echo "<td>".$fila["cod_alu"]."</td>";
                                echo "<td>".$fila["nombre"]."</td>";
                                echo "<td>".$fila["telefono"]."</td>";
                                echo "<td>".$fila["cp"]."</td>";
                    echo"<tr>";


                }
        echo"</table>";
        
        //Liberar resultado solo en los select
        mysqli_free_result($resultado);
                       
        mysqli_close($conexion);
        ?>
    
</body>
</html>