<?php
//No estoy logueado
    if(isset($_POST["btnEntrar"]))
    {
        $error_usuario=$_POST["usuario"]=="";
        $error_clave=$_POST["clave"]=="";
        $error_form=$error_usuario||$error_clave;
        if(!$error_form)
        {
            try {
                $consulta="select * from usuarios where lector= ? and clave= ?";
                $sentencia = $conexion->prepare($consulta);
                $sentencia->execute([$_POST["usuario"], md5($_POST["clave"])]);
            } catch (PDOException $e) {
                session_destroy();
                $sentencia = null;
                $conexion = null;
                die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
            }

            
            if($sentencia->rowCount()>0)
            {
                $_SESSION["usuario"]=$_POST["usuario"];
                $_SESSION["clave"]=md5($_POST["clave"]);
                $_SESSION["ultima_accion"]=time();
                $datos_usu_log=$sentencia->fetchAll(PDO::FETCH_ASSOC);
                $sentencia=null;
                $conexion=null;

                if($datos_usu_log["tipo"]=="normal")
                {
                    header("Location:index.php");
                }
                else
                {
                    header("Location:admin/gest_libros.php");
                }
                exit();
            }
            else
                $error_usuario=true;
         
            $sentencia=null;
        }

    }


?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen3 Curso 23-24</title>
        <style>
            img{height:200px}
            p.libros{text-align:center;width:30%;margin-top:2.5%;margin-left:2.5%;float:left}
        </style>
    </head>
    <body>
        <h1>Librería</h1>
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
                <?php
                if(isset($_POST["usuario"])&& $error_usuario)
                    if($_POST["usuario"]=="")
                        echo "<span class='error'> Campo vacío</span>"; 
                    else
                        echo "<span class='error'> Usuario/clave incorrectos</span>"; 
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" id="clave">
                <?php
                if(isset($_POST["clave"])&& $error_clave)
                    echo "<span class='error'> Campo vacío</span>";    
                ?>
            </p>
            <p>
                <button type="submit" name="btnEntrar">Entrar</button>
            </p>
        </form>
        <?php
        if(isset($_SESSION["seguridad"]))
        {
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
            session_destroy();
        }


        require "vistas/vista_libros_atres.php";
        ?>
    </body>
    </html>
