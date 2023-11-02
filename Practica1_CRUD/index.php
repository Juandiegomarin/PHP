<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 1 CRUD</title>
    <style>
        table,td,th{border: 1px solid black;}
        table{border-collapse: collapse;text-align: center;}
        th{background-color: #CCC;}
        table img{
            height: 60px;
            width: 60px;
        }
    </style>
</head>
<body>
        <h1>Listado de los usuarios</h1>

        <?php
        try {   
                 //Realizar conexión
                 $conexion=mysqli_connect("localhost","jose","josefa","bd_foro");
                 mysqli_set_charset($conexion,"utf8");
        } catch (Exception $e) {
            die ("<p>No ha podido conectarse a la a base de datos:".$e->getMessage()."</p></body></html>");
        }

        

        try{
            $consulta="select * from usuarios";
            $resultado=mysqli_query($conexion,$consulta);

        }catch(Exception $e){
            mysqli_close($conexion);
            die ("<p>No ha podido realizar la consulta:".$e->getMessage()."</p></body></html>");
        }

        echo"<table>";
        echo "<tr>
                    <th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th>
             </tr>";
             while($tupla=mysqli_fetch_assoc($resultado)){

                echo "<tr>
                            <td>".$tupla["nombre"]."</td>
                            <td><img src='images/error.png' alt='Imagen de borrar' title='Imagen de borra'></td>
                            <td><img src='images/lapiz.png' alt='Imagen de borrar' title='Imagen de borra'></td>
                </tr>";
             }
        echo"</table>";
        echo "<p><form action='usuario_nuevo.php' method='post' enctype='multipart/form-data'>
        

        <button type='submit' name='insertar'>Inserta nuevo usuario</button>
        
              </form></p>";
        mysqli_close($conexion);
        ?>
</body>
</html>