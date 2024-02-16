<?php

echo "<p>Respuestas:</p>";
echo "Nombre: ".$_POST["name"]."</p>";
echo "Apellido: ".$_POST["ape"]."</p>";
echo "Contraseña: ".$_POST["pass"]."</p>";
echo "DNI: ".$_POST["nif"]."</p>";
echo "Sexo: ".$_POST["sexo"]."</p>";
echo "Nacimiento: : ".$_POST["nacido"]."</p>";
echo "Comentario: : ".$_POST["message"]."</p>";
echo "Subscripción: ".$_POST["sub"]."</p>";

if($_FILES["foto"]["name"] != ""){
$nombre_nuevo=md5(uniqid(uniqid(),true));
$array_nombre=explode(".",$_FILES["foto"]["name"]);
$ext="";

if (count($array_nombre)>1) {
    $ext=".".end($array_nombre);

}
$nombre_nuevo.=$ext;
@$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_nuevo);

if ($var) {
    echo"<h3>Foto</h3>";
    echo"<p><strong>Nombre: </strong>".$_FILES["foto"]["name"]."</p>";
    echo"<p><strong>Tipo: </strong>".$_FILES["foto"]["type"]."</p>";
    echo"<p><strong>Tamaño: </strong>".$_FILES["foto"]["size"]."</p>";
    echo"<p><strong>Error: </strong>".$_FILES["foto"]["error"]."</p>";
    echo"<p><strong>Nombre Temporal: </strong>".$_FILES["foto"]["tmp_name"]."</p>";
    echo"<p>La imagen se ha subido con éxito</p>";
    echo"<p><img class='tanImagen' src='images/".$nombre_nuevo."' alt='Foto' title='foto'></p>";


}else{
    echo"<p>No se ha podido mover la imagen a la carpeta destino en el servidor</p>";
}
}else{

    echo"<p>No hay imagen</p>";

}




?>