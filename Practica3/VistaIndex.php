<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <style>
            .error {
                color: red;
            }
        </style>
    </head>

    <body>
        <h1>
            Rellena tu CV
        </h1>

        <form action="Index.php" method="post" enctype="multipart/form-data">

            <p><label for="name">Nombre</label></p>
            <p><input type="text" name="name" id="name" value="<?php if (isset($_POST["name"])) {
                                                                    echo $_POST["name"];
                                                                }   ?>">

                <?php
                if (isset($_POST["botonGuardar"])&&$error_nombre) {

                    echo "<span class='error'>Campo vacio </span>";
                }

                ?>
            </p>


            <p><label for="ape">Apellido</label></p>
            <p><input type="text" name="ape" id="ape" value="<?php if (isset($_POST["ape"])) {
                                                                    echo $_POST["ape"];
                                                                }   ?>">

                <?php
                if (isset($_POST["botonGuardar"])&&$error_ape) {

                    echo "<span class='error'>Campo vacio </span>";
                }

                ?>
            </p>

            <p><label for="pass">Contraseña</label></p>
            <p><input type="password" name="pass" id="pass" value="<?php if (isset($_POST["pass"])) {
                                                                        echo $_POST["pass"];
                                                                    }   ?>">

                <?php
                if (isset($_POST["botonGuardar"])&&$error_pass) {

                    echo "<span class='error'>Campo vacio </span>";
                }

                ?>
            </p>

            <p><label for="nif">DNI</label></p>
            <p><input type="text" name="nif" id="nif" value="<?php if (isset($_POST["nif"])) {
                                                                    echo $_POST["nif"];
                                                                }   ?>">
                <?php
                if (isset($_POST["botonGuardar"])&&$error_nif) {

                    echo "<span class='error'>Campo vacio </span>";
                }

                ?>
            </p>

            <p>Sexo</p>

            <?php
            if (isset($_POST["botonGuardar"])&&$error_sex) {

                echo "<span class='error'>Eliga un sexo </span>";
            }

            ?>

            <input type="radio" name="sexo" id="Hombre" value="Hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Hombre") {
                                                                            echo "checked";
                                                                        }   ?>>
            <label for="Hombre">Hombre</label>
            <input type="radio" name="sexo" id="Mujer" value="Mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Mujer  ") {
                                                                            echo "checked";
                                                                        }   ?>>
            <label for="Mujer">Mujer</label>

            <p>Incluir mi foto <input type="file" name="foto" accept="image/*" /></p>

            <label for="nacido">Nacido en: </label>

            <select name="nacido" id="nacidor">

                <option value="Malaga">Malaga</option>

                <option value="Cadiz">Cadiz</option>

                <option value="Sevilla">Sevilla</option>

            </select>

                                                                        


          <p>Comentarios:<textarea id="message" name="message" rows="6" cols="30"><?php if (isset($_POST["message"])) { echo $_POST["message"];}?></textarea>
                <?php
                    if (isset($_POST["botonGuardar"]) && $error_comentario) {
                    echo "<span class='error'>Campo vacio </span>";
                }?>


            </p>

            



            <p><input type="checkbox" name="sub" checked>Suscribete al boletin de novedades</p>

            <button type="submit" name="botonGuardar">Guardar Cambios</button>
            <button type="reset" name="botonBorrar">Borrar datos introducidos</button>

        </form>

    </body>

    </html>