<?php
session_name("Examen_17_18");
session_start();
require "../ctes_func.php";
?>
<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Logeado</title>
        <style>
            .enlace {
                border: none;
                background: none;
                cursor: pointer;
                color: blue;
                text-decoration: underline;
            }

            .enlinea {
                display: inline
            }
            table{
                border: 1px solid black;
                width: 60%;
                text-align: center;
                
            }
            th{
                background-color: lightgray;
            }
            table img {
            height: 60px;
            width: 60px;
        }
        </style>
    </head>

    <body>
        <?php
        try {

            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen Login", "<h1>Primer Login</h1><p>No ha podido conectar a la base de batos: " . $e->getMessage() . "</p>"));
        }
        ?>
        <h1>VideoClub</h1>
        <div>Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong> -
            <form class='enlinea' action="../index.php" method="post">
                <button class='enlace' type="submit" name="btnSalir">Salir</button>
            </form>
        </div>

        <h2>Listado de Peliculas</h2>
        <?php
        try {
            $consulta = "select * from peliculas";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Examen Login", "<h1>Primer Login</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }

        echo"<table>";
        echo"<tr><th>id</th><th>Titulo</th><th>Carátula</th></tr>";
        while($datos_pelis=mysqli_fetch_assoc($resultado)){
            echo "<tr><td>".$datos_pelis["idPelicula"]."</td><td>".$datos_pelis["titulo"]."</td><td><img src='../Img/".$datos_pelis["caratula"]."'/></td></tr>";
        }
        echo"</table>";
        ?>
    </body>

    </html>