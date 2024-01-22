<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Recogiendo datos</h2>
    <?php

    
    if (isset($_POST["botonEnviar"])) {

        echo "<p><strong>Nombre: </Strong>" . $_POST["name"] . "</p>";
        echo "<p><strong>Nacido: </Strong>" . $_POST["nacido"] . "</p>";
        if (isset($_POST["sexo"])) {
            echo "<p><strong>Sexo: </Strong>" . $_POST["sexo"] . "</p>";
        } else {
            echo "<p><strong>Sexo: </Strong> Vacio</p>";
        }
        

        if (isset($_POST["deporte"]))
            echo "<p><strong>Deporte: </Strong> Si </p>";
        else  echo "<p><strong>Deporte: </Strong> No </p>";

        if (isset($_POST["lectura"]))
            echo "<p><strong>Lectura: </Strong> Si </p>";
        else  echo "<p><strong>Lectura: </Strong> No </p>";

        if (isset($_POST["otro"]))
            echo "<p><strong>Otros: </Strong> Si </p>";
        else  echo "<p><strong>Otros: </Strong> No </p>";

        echo "<p><strong>Comentarios: </Strong>" . $_POST["comentario"] . "</p>";

    } else {
        header("Location:Index.php");
    }
    ?>

</body>

</html>