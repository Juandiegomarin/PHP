<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ejercicio3</title>
</head>

<body>

    <h1>Ejercicio 3</h1>

    <form action="Ejercicio3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="texto">Introduce un texto:</label>
            <input type="text" name="texto" id="texto">
            <label for="separador">Seleccione separador</label>
            <select name="separadores" id="separadores">

                <option value=" "> </option>
                <option value=".">.</option>
                <option value=",">,</option>
                <option value=":">:</option>
                <option value=";">;</option>

            </select>
        </p>

        <p>
            <button type="submit" name="calcular">Calcular</button>
        </p>


    </form>
    <?php
    function contarLongitud($text)
    {
        $cont = 0;
        while (isset($text[$cont])) {
            $cont++;
        }

        return $cont;
    }
    $separador = $_POST["separadores"];
    function dividir($text,$separador)
    {
        
        $cont = 0;
        for ($i = 0; $i < contarLongitud($text); $i++) {

            $cont++;
        }
        return $cont;
    }
    if (isset($_POST["calcular"])) {

        echo "El numero de palabras que hay es: " . dividir($_POST["texto"],$separador);
    }



    ?>


</body>

</html>