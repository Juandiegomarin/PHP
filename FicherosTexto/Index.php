<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <?php
        @$fd1 = fopen("prueba.txt","r");
        if(!$fd1)
            die("<p>No se ha podido abrir el archivo prueba.txt</p>");

        echo"<p>Por ahora todo en orden </p>";


        $linea=fgets($fd1);
        echo"<p>".$linea."</p>";

        fseek($fd1,0);
        
        while ($linea=fgets($fd1)) {
            echo"<p>".$linea."</p>";
        }
        //Constante PHP_EOL.
        
        fclose($fd1);
        ?>
</body>
</html>