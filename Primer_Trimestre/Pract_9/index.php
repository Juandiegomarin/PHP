<?php
require "src/constantes_funciones.php";

if(isset($_POST["btnDetalle"])){

    echo $_POST["btnDetalle"];

    try {
        $conexion=mysqli_connect("localhost","jose","josefa","bd_videoclub");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No se ha podido acceder a la : ".$e->getMessage()."</p>");
    }

    echo"<form><button action='index.php'>Volver</button></form>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 9</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 90%;
            margin: 0 auto
        }

        .gris {
            background-color: lightgrey;
        }

        .enlace {
            text-decoration: underline;
            color: blue;
            background: none;
            border: none;
            cursor: pointer;
        }
        img{
            height: 50px;
        }
    </style>
</head>

<body>
    <h1>Video Club</h1>
    <h2>Películas</h2>
    <h3>Listado de películas</h3>
    <?php
   
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_videoclub");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {

        die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
    }

    try {
        $consulta="select * from peliculas";
        $resultado=mysqli_query($conexion,$consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta:".$e->getMessage()." </p></body></html>");
    }
    echo "<table>
    
    <tr>
            <th class='gris'>id</th>
            <th class='gris'>Título</th>
            <th class='gris'>Carátula</th>
            <th class='gris'><form action='index.php' method='post'><button class='enlace' name='btnInsertar'>Películas+</button></form></th>
    </tr>
    ";
       while($tupla=mysqli_fetch_assoc($resultado)){

        echo "<tr>
                <td>".$tupla["idPelicula"]."</td>
                <td><form action='index.php' method='post'><button class='enlace' name='btnDetalle' value='".$tupla["idPelicula"]."'>".$tupla["titulo"]."</button></form></td>
                <td><img src='Img/".$tupla["caratula"]."'/></td>
                <td><form action='index.php' method='post'><button class='enlace' name='btnBorrar' value='".$tupla["idPelicula"]."'>Borrar</button>-<button class='enlace' name='btnEditar' value='".$tupla["idPelicula"]."'>Editar</button></form></td>
        
        </tr>";
        
       } 

    echo "</table>";

    ?>


</body>

</html>