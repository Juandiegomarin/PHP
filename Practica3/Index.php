<?php


function letraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}
function dni_bien_escrito($texto)
{
    return strlen($texto) == 9 && is_numeric(substr($texto, 0, 8)) && substr($texto, -1) >= "A" && substr($texto, -1) <= "Z";
}
function dni_valido($texto)
{
    $numero = substr($texto, 0, 8);
    $letra = substr($texto, -1);
    $valido = letraNIF($numero) == $letra;
    return $valido;
}

if (isset($_POST["botonGuardar"])) { //Compruebo errores

    $error_nombre = $_POST["name"] == "";
    $error_ape = $_POST["ape"] == "";
    $error_pass = $_POST["pass"] == "";
    $error_nif = $_POST["nif"] == "" || !dni_bien_escrito(strtoupper($_POST["nif"])) || !dni_valido($_POST["nif"]);
    $error_sex = !isset($_POST["sexo"]);
    $error_comentario = $_POST["message"] == "";
    $error_archivo =$_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024);
    
    $error_form = $error_nombre || $error_ape || $error_pass || $error_sex || $error_nif || $error_comentario|| $error_archivo;
    
}

if ( isset($_POST["botonGuardar"])&&!$error_form) {

    require('VistaRespuesta.php');
} else {
?>
                            
<?php
    require('VistaIndex.php');
}
?>