<?php
    
    function error_page($title,$body)
    {
        $html='<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html.='<title>'.$title.'</title></head>';
        $html.='<body>'.$body.'</body></html>';
        return $html;
    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen2 PHP</title>
    </head>
    <body>
        <h1>Examen2 PHP</h1>
        <h2>Horario de los Profesores</h2>

        <?php
            try {
                $conexion=mysqli_connect("localhost","jose","josefa","bd_horarios_exam");
                mysqli_set_charset($conexion,"utf8");
            } catch (Exception $e) {
                die("<p>No se ha podido conectar a la base de datos:".$e->getMessage()."</p></body></html>");
            }
        
        ?>
    </body>
</html>