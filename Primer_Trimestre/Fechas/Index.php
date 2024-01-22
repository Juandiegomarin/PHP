<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria PHP</title>
</head>

<body>

    <h1>Teoria fechas</h1>

    <?php
    echo "<p>".time()."</p>";
    echo "<p>".date("d/m/Y h:i:s")."</p>";
    echo "<p>".checkdate(2,28,2023)."</p>";
    echo "<p>".mktime(0,0,0,11,21,2002)."</p>";
    echo "<p>".date("d/m/Y",mktime(0,0,0,11,21,2002))."</p>";
    echo "<p>".strtotime("11/21/2002")."</p>";
    
    ?>

</body>

</html>