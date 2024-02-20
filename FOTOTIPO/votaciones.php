<?php
header('Access-Control-Allow-Origin: *');
//Se abre el fichero deonde están almacenados los datos
$fichero = "resultado.txt";
$contenido = file($fichero);   // ns que hace con esto

//colocamos el contenido en un array y lo almacenamos en cuatro variables por equipos
$array = explode("||", $contenido[0]);
$tipo1 = $array[0];
$tipo2 = $array[1];
$tipo3 = $array[2];
$tipo4 = $array[3];
$tipo5 = $array[4];
$tipo6 = $array[5];

//extraemos el voto de los participantes
$voto = $_GET['voto'];
//actualizamos los votos añadiendo el recibido a los anteriores
switch ($voto) {
  case 1:
    $tipo1++;
    break;
  case 2:
    $tipo2++;
    break;
  case 3:
    $tipo3++;
    break;
  case 4:
    $tipo4++;
    break;
  case 5:
    $tipo5++;
    break;
  case 6:
    $tipo6++;
    break;
}


$insertvoto = $tipo1 . "||" . $tipo2 . "||" . $tipo3 . "||" . $tipo4 . "||" . $tipo5 . "||" . $tipo6;


$fp = fopen($fichero, "w");
fputs($fp, $insertvoto);
fclose($fp);


$denominador = (int)$tipo1 + (int)$tipo2 + (int)$tipo3 + (int)$tipo4  + (int)$tipo5 + (int)$tipo6;
$totalTipo1 = 100 * round($tipo1 / $denominador, 2);
$totalTipo2 = 100 * round($tipo2 / $denominador, 2);
$totalTipo3 = 100 * round($tipo3 / $denominador, 2);
$totalTipo4 = 100 * round($tipo4 / $denominador, 2);
$totalTipo5 = 100 * round($tipo5 / $denominador, 2);
$totalTipo6 = 100 * round($tipo6 / $denominador, 2);

echo json_encode([round($totalTipo1),round($totalTipo2),round($totalTipo3),round($totalTipo4),round($totalTipo5),round($totalTipo6)]);
?>