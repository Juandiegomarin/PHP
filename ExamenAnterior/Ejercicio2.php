<?php
if(isset($_POST["subir"])){

$error_form= $_FILES["fichero"]["name"]==""||$_FILES["fichero"]["error"]||$_FILES["fichero"]["type"]!="text/plain"|| $_FILES["fichero"]["size"]>1000*1024;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error{color: red;}
        .correcto{color:green}
    </style>
</head>
<body>

        <h1>Ejercicio 2</h1>

        <form action="Ejercicio2.php" method="post" enctype="multipart/form-data">

        <p>
                <label for="fichero">Sube un fichero de menos de 1MB</label>
                <input type="file" name="fichero" id="fichero">
                <?php

                if(isset($_POST["subir"])&&$error_form){

                    if($_FILES["fichero"]["error"])
                    echo"<span class='error'>Error al subir el archivo</span>";
                    else if($_FILES["fichero"]["type"]!="text/plain")
                    echo"<span class='error'>El archivo no es tipo txt</span>";
                    else{
                        echo"<span class='error'>El archivo supera 1MB</span>";
                    }

                }
                ?>

        </p>
        <p>
            <button type="submit" name="subir">Subir Archivo</button>
        </p>

        </form>
        
        <?php
        if(isset($_POST["subir"])&& !$error_form){

            


            @$variable=move_uploaded_file($_FILES["fichero"]["tmp_name"],"Ficheros/archivo.txt");
            if($variable){
                echo"<p class='correcto'>Archivo subido con éxito</p>";
            }else{
                echo"<p class='error'>Archivo no subido</p>";
            }



        }
        ?>   
</body>
</html>