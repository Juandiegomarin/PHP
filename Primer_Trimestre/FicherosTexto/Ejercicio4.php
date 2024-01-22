<?php
if(isset($_POST["btnContar"]))
{
    //echo $_FILES["fichero"]["type"] para saber extension del archivo
    $error_form=$_FILES["fichero"]["name"]==""||$_FILES["fichero"]["error"]||$_FILES["fichero"]["type"]!="text/plain"|| $_FILES["fichero"]["size"]>1000*1024;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4 Ficheros de texto</title>
    <style>
        .error{color: red;}
    </style>
</head>
<body>

        <h1>Ejercicio 4 </h1>

        <form action="Ejercicio4.php" method="post" enctype="multipart/form-data">

            <p>
                <label for="fichero">Seleccione un fichero de texto para contar sus palabras (Max. 2,5MB)</label>
                <input type="file" name="fichero" id="fichero" accept=".txt">
                <?php
                if(isset($_POST["btnContar"])&&$error_form)
                {

                    if($_FILES["fichero"]["name"]=="")
                        echo"<span class='error'>*</span>";
                    elseif ($_FILES["fichero"]["error"]) 
                        echo"<span class='error'>No se ha podido subir el fichero al servidor</span>";
                    elseif ($_FILES["fichero"]["type"]!="text/plain") 
                        echo"<span class='error'>Error: No has seleccionado un fichero .txt</span>";
                    else
                         echo"<span class='error'>Error: El tamaño del fichero es superior a 2'5MB</span>";  

                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnContar"> Contar Palabras</button>
            </p>

        </form>
        <?php
        if(isset($_POST["btnContar"])&& !$error_form){


            $contenido_fichero=file_get_contents($_FILES["fichero"]["tmp_name"]);
            echo"<h3>El archivo tiene: ".str_word_count($contenido_fichero)." palabras</h3>";


        }

        ?>
    
</body>
</html>