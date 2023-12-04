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

    /*$a[0]=3;
    $a[1]=6;
    $a[2]=-1;
    $a[3]=8;

    for($i=0;$i<count($a);$i++){

        echo"<p>Número: ".$a[$i]."</p>";
    }
    */
    if (isset($_POST["botonGuardar"])) {

        echo "<p><strong>Nombre: </Strong>" . $_POST["name"] . "</p>";
        echo "<p><strong>Apellido: </Strong>" . $_POST["ape"] . "</p>";
        echo "<p><strong>Contraseña: </Strong>" . $_POST["pass"] . "</p>";
        echo "<p><strong>DNI: </Strong>" . $_POST["nif"] . "</p>";
        if (isset($_POST["sexo"])) {
            echo "<p><strong>Sexo: </Strong>" . $_POST["sexo"] . "</p>";
        } else {
            echo "<p><strong>Sexo: </Strong> Vacio</p>";
        }
        echo "<p><strong>Nacido: </Strong>" . $_POST["LugarNacimiento"] . "</p>";

        if (isset($_POST["novedades"]))
            echo "<p><strong>Sub: </Strong> Si </p>";
        else  echo "<p><strong>Sub: </Strong> No </p>";
    } else {
        header("Location:Index.php");
    }
    ?>

</body>

</html>