<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 10</title>
</head>

<body>

    <?php


$naturales;

for ($i=0; $i <10 ; $i++) { 
    $naturales[]=$i+1;
    
}


$contador=0;
$suma=0;


for ($i=0; $i <count($naturales) ; $i++) { 

    if(($naturales[$i]% 2)!=0)
    echo "<p>Numero impar: ".$naturales[$i]."</p>";
    else{
    $suma+=$naturales[$i]; 
    $contador++;
    }

}

echo"<p>La media de los numeros pares es: ".($suma/$contador)."<p/>";



?>

</body>

</html>