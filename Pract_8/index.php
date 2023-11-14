<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 8</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

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
    </style>
</head>

<body>

    <h1>Practica 8</h1>



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
    echo "<td><button class='enlace' type='submit' name='botonInsertar'>Usuario +</button></td>";
    echo "<tr>";
    while($arr = mysqli_fetch_assoc($resultado)) { 
        echo "<tr>";
        echo "<td>".$arr["id_usuario"]."</td>";
        if($arr['foto']=="no_imagen.jpg")
        echo "<td><img src='img/no_imagen.jpg' title='Sin imagen' width='100px'></td>";
        else
        echo "<td>".$arr["foto"]."</td>";
        
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='botonDetalle'>".$arr['nombre']."</button></form></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='botonBorrar'>Borrar</button><span class='azul'>-</span><button class='enlace' type='submit' name='botonEditar'>Editar</button></form></td>";
        echo "</tr>";
    }

    echo " </table>";
    ?>
</body>

</html>