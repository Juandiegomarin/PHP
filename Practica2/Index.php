<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario 2</title>
</head>
<body>

<h1>Esta es mi super página</h1>
    
<form action="" method="post" enctype="multipart/form-data">

<label for="name">Nombre: </label>
<input type="text" name="name" id="name">

<p></p>

<label for="nacido">Nacido en:</label>
<select name="nacido" id="nacido">

<option value="Malaga">Malaga</option>
<option value="Estepona">Estepona</option>
<option value="Sabinillas">Sabinillas</option>

</select>

<p></p>

<label for="sex">Sexo:</label>

<label for="hombre">Hombre</label>
<input type="radio" name="sex" id="hombre">

<label for="mujer">Mujer</label>
<input type="radio" name="sex" id="mujer">

<p></p>

<label for="aficiones">Aficiones:</label>

<label for="deporte">Deportes</label>
<input type="checkbox" name="deporte" id="deporte">

<label for="lectura">Lectura</label>
<input type="checkbox" name="lectura" id="lectura">

<label for="otro">Otros</label>
<input type="checkbox" name="otro" id="otro">

<p></p>

<label for="comentario">Comentarios:</label>
<textarea name="comentario" id="comentario" cols="15" rows="2"></textarea>

<p></p>

<button type="submit" name="botonEnviar">Enviar</button>
</form>

</body>
</html>