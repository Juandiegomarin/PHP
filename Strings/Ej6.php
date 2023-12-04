<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <style>
        form {
    width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: rgb(112, 210, 255);
}
p {
    width: 400px;
    margin: 0 auto;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: rgb(179, 255, 172);
}
    </style>
    <form action="index.php" method="post">
        <label for="palabra">Introduce texto:</label>
        <textarea name="palabra" id="palabra" cols="30" rows="10" required value="<?php
        if (isset($_POST['palabra'])) {
            echo $_POST['palabra'];
        } else {
            echo "";
        }
    ?>"></textarea>
        <input type="submit" value="Comprobar" name="submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $palabra = $_POST['palabra'];
        $palabra = strtolower($palabra);
        $palabra = str_replace('á', 'a', $palabra);
        $palabra = str_replace('é', 'e', $palabra);
        $palabra = str_replace('í', 'i', $palabra);
        $palabra = str_replace('ó', 'o', $palabra);
        $palabra = str_replace('ú', 'u', $palabra);
        echo "<p>La palabra sin acentos es: $palabra</p>";
    }
    ?>
</body>

</html>