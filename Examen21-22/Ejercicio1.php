<?php

    function primera_linea()
    {
        $res="i/j";
        for($j=1;$j<=5;$j++)
            $res.=";".$j;
        return $res;
    }

    function generar_fichero_clavesPolybios()
    {
        @$fd=fopen("claves_polybios.txt","w");
        if(!$fd)
            die("NO se ha podido crear el fichero 'claves_polybios.txt'");
        
        $linea=primera_linea();

        fputs($fd,$linea.PHP_EOL);
        $k=ord("A");
        for($i=1;$i<=5;$i++)
        {
            $linea=$i;
            for($j=1;$j<=5;$j++)
            {
                if($i==2 && $j==5)
                    $k++;
                $linea.=";".chr($k);
                $k++;
            }
            
            fputs($fd,$linea.PHP_EOL);
        }
        fclose($fd);
        return file_get_contents("claves_polybios.txt");
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 1 PHP</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <h1>Ejercicio 1. Generador de "claves_polybios.txt"</h1>
        <form method="post" action="Ejercicio1.php">
            <input type="submit" name="botonGenerar" value="Generar"/>
        </form>
        <?php
        if(isset($_POST["botonGenerar"]))
        {
            echo "<h1>Respuesta</h1>";
            echo "<textarea>".generar_fichero_clavesPolybios()."</textarea>";
            echo "<p>Fichero generado con éxito</p>";
        }
        ?>
    </body>
</html>