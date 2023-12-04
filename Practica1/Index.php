<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>
        Rellena tu CV
    </h1>

    <form action="recogida.php" method="post" enctype="multipart/form-data">

        <p><label for="name">Nombre</label></p>
        <p><input type="text" name="name" id="name"></p>

        <p><label for="ape">Apellido</label></p>
        <p><input type="text" name="ape" id="ape"></p>

        <p><label for="pass">Contraseña</label></p>
        <p><input type="password" name="pass" id="pass"></p>

        <p><label for="nif">DNI</label></p>
        <p><input type="text" name="nif" id="nif"></p>


        <p>Sexo</p>

        <input type="radio" name="sexo" id="Hombre" value="Hombre">
        <label for="Hombre">Hombre</label>
        <input type="radio" name="sexo" id="Mujer" value="Mujer">
        <label for="Mujer">Mujer</label>

        <p>Incluir mi foto <input type="file" name="foto" accept="image/*" /></p>

        <label for="nacido">Nacido en: </label>

        <select name="LugarNacimiento" id="lugar">

            <option value="Malaga">Malaga</option>

            <option value="Cadiz">Cadiz</option>

            <option value="Sevilla">Sevilla</option>

        </select>


        <p>Comentarios: <textarea name="message" rows="6" cols="30">

                </textarea></p>


        <p><input type="checkbox" name="novedades" checked value="value1">Suscribete al boletin de novedades</p>

        <button type="submit" name="botonGuardar">Guardar Cambios</button>
        <button type="reset" name="botonBorrar">Borrar datos introducidos</button>

    </form>

</body>

</html>