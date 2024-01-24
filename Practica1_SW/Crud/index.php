<?php
session_name("Crud_SW");
session_start();
define("DIR_SERV", "http://localhost/Proyectos/Practica1_SW/servicios_rest");

function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <style>
        .centrado{
            text-align: center;
        }
        table,td,th,tr{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
        table{
            width:60% ;
        }
        .enlace{
            cursor: pointer;
            background: none;
            color: blue;
            border: none;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h1 class="centrado">Listado de productos</h1>
<?php

if(isset($_POST["btnInsertar"])){
    echo "<h2>Creando un producto</h2>";
    ?>
    <form action="index.php" method="post">

    <p>
    <label for="codigo">Codigo:</label>
    <input type="text" name='codigo' id='codigo'/>
    </p>

    <p>
    <label for="nombre">Nombre:</label>
    <input type="text" name='nombre' id='nombre'/>
    </p>

    <p>
    <label for="nombre_corto">Nombre Corto:</label>
    <input type="text" name='nombre_corto' id='nombre_corto'/>
    </p>

    <p>
        <label for="descripcion">Descripcion:</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="3"></textarea>
    </p>
    <p>
        <label for="pvp">PVP:</label>
        <input type="text" name='pvp' id='pvp'>
    </p>



    </form>
<?php    
}



$url = DIR_SERV . "/productos";
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Error consumiendo el servicio " . $url . " </p>" . $respuesta);
if(isset($obj->mensaje_error)){
    echo "<p>".$obj->mensaje_error."</p>";
}

echo"<table>";

echo"<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><form method='post' action='index.php'><button class='enlace' name='btnInsertar'>Productos+</button></form></th></tr>";
foreach ($obj->productos as $producto) {
    echo"<tr><td>".$producto->cod."</td><td>".$producto->nombre_corto."</td><td>".$producto->PVP."</td><td><form method='post' action='index.php'><button class='enlace' value='".$producto->cod."'name='btnBorrar'>Borrar</button>-<button class='enlace' value='".$producto->cod."' name='btnEditar'>Editar</button></form></td></tr>";
}

echo"</table>";
?>
    
</body>
</html>