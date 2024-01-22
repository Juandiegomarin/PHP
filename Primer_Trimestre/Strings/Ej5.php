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
        <label for="numero">Introduce un número:</label>
        <input type="number" name="numero" id="numero" required value="<?php
        if (isset($_POST['numero'])) {
            echo $_POST['numero'];
        } else {
            echo "";
        }
    ?>">
        <input type="submit" value="Convertir" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $numero = $_POST['numero'];
        if ($numero > 5000){
            echo "<p>El número introducido es mayor que 5000</p>";
        } else {
        $numeros = [
            "M" => 1000,
            "CM" => 900,
            "D" => 500,
            "CD" => 400,
            "C" => 100,
            "XC" => 90,
            "L" => 50,
            "XL" => 40,
            "X" => 10,
            "IX" => 9,
            "V" => 5,
            "IV" => 4,
            "I" => 1
        ];
        $romano = "";
        foreach ($numeros as $letra => $valor) {
            while ($numero >= $valor) {
                $numero -= $valor;
                $romano .= $letra;
            }
        }
        echo "<p>El número escrito en romano es: $romano</p>";
    }
    }
    ?>
</body>

</html>