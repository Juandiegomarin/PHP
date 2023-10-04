<?php
if (isset($_POST["botonEnviar"])) {

    $error_achivo = $_FILES["archivo"]["name"] == "" ||
        $_FILES["archivo"]["error"] ||
        !getimagesize($_FILES["archivo"]["tmp_name"]) ||
        $_FILES["archivo"]["size"] > 500 * 1024;
}
if (isset($_POST["botonEnviar"]) && !$error_achivo) {

    echo "Contesto con la info del archivo subido";
} else {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teoria de ficheros servidor</title>
        <style>
            .error {
                color: red
            }
        </style>
    </head>

    <body>

        <h1>Teoria subir ficheros al servidor</h1>
        <form action="Index.php" method="post" enctype="multipart/form-data">

            <p>
                <label for="archivo">Seleccione un archivo de imagen(Max 500KB)</label>
                <input type="file" name="archivo" id="archivo" accept="image/*">
                <?php
                if (isset($_POST["botonEnviar"]) && $error_achivo) {


                    if ($_FILES["archivo"]["error"]) {
                        echo "<span class='error'>No se ha podido subir el archivo al servidor</span>";
                    } elseif (!getimagesize($_FILES["archivo"]["tmp_name"])) {

                        echo "<span class='error'>No has seleccionado un archivo de imagen</span>";
                    } else {
                        echo "<span class='error'>La imagen supera los 500KB</span>";
                    }
                }
                ?>
            </p>
            <p>
                <button type="submit" name="botonEnviar">Enviar</button>
            </p>




        </form>

    </body>

    </html>
<?php
}
?>