<!DOCTYPE html>
<html>
<head>
    <title>Ejercicio 3 - Decodificar archivo</title>
</head>
<body>
    <h1>Ejercicio 3 - Decodificar archivo</h1>

    <?php
    // Función para decodificar el texto utilizando el cifrado César
    function decodificarCesar($textoCodificado, $clave) {
        $textoDecodificado = "";
        $longitudTexto = strlen($textoCodificado);
        for ($i = 0; $i < $longitudTexto; $i++) {
            $caracter = $textoCodificado[$i];
            if (ctype_alpha($caracter)) {
                $ascii = ord($caracter);
                $ascii = ($ascii - $clave + 65) % 26 + 65;
                $caracterDecodificado = chr($ascii);
                $textoDecodificado .= $caracterDecodificado;
            } else {
                $textoDecodificado .= $caracter;
            }
        }
        return $textoDecodificado;
    }

    // Función para obtener la fecha actual en el formato deseado
    function obtenerFechaActual() {
        $fechaActual = date("l, \dí\a d \d\e F \d\e Y \a \l\a\s H:i \h\o\r\a\s.");
        return $fechaActual;
    }

    // Ruta de los archivos de texto
    $rutaCodificado = "codificado.txt";
    $rutaDecodificado = "decodificado.txt";

    // Variables para almacenar los mensajes de error y éxito
    $error = "";
    $exito = "";

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se ha seleccionado un archivo
        if ($_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {
            // Obtener la ruta temporal del archivo subido
            $archivoTemporal = $_FILES["archivo"]["tmp_name"];

            // Verificar si el archivo es de texto
            if ($_FILES["archivo"]["type"] == "text/plain") {
                // Mover el archivo a la ruta especificada
                move_uploaded_file($archivoTemporal, $rutaCodificado);

                // Decodificar el archivo codificado.txt y guardar el resultado en decodificado.txt
                $claveDesconocida = 3; // Clave desconocida para el cifrado César
                $textoCodificado = file_get_contents($rutaCodificado);
                $textoDecodificado = decodificarCesar($textoCodificado, $claveDesconocida);
                file_put_contents($rutaDecodificado, $textoDecodificado);

                // Agregar la última línea con la fecha en el archivo decodificado.txt
                $fechaActual = obtenerFechaActual();
                file_put_contents($rutaDecodificado, $fechaActual, FILE_APPEND);

                $exito = "El archivo codificado.txt ha sido decodificado y el resultado se ha guardado en decodificado.txt.";
            } else {
                $error = "El archivo seleccionado no es de texto.";
            }
        } else {
            $error = "No se ha seleccionado ningún archivo.";
        }
    }
    ?>

    <?php if (!empty($error)) { ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php } ?>

    <?php if (!empty($exito)) { ?>
        <div style="color: green;"><?php echo $exito; ?></div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="archivo">Selecciona un archivo de texto:</label>
        <input type="file" name="archivo" id="archivo" accept=".txt">
        <br>
        <input type="submit" value="Decodificar archivo">
    </form>

    <?php if (file_exists($rutaDecodificado)) { ?>
        <h2>Contenido del archivo decodificado.txt:</h2>
        <pre>
            <?php
            // Mostrar el contenido del archivo decodificado.txt
            $contenidoDecodificado = file_get_contents($rutaDecodificado);
            echo $contenidoDecodificado;
            ?>
        </pre>
    <?php } ?>
</body>
</html>