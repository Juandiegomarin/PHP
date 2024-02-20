<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio17</title>
</head>
<body>

<?php

$familias = array("Los Simpsons"=> array("Padre"=>"Homer", "Madre"=>"Marge", "Hijos"=> array("Bart","Lisa","Magie")),"Los grifin"=> array("Padre"=>"Peter", "Madre"=>"Lois", "Hijos"=> array("Chris","Meg","Stewie")));

            echo "<ul>";
        foreach($familias as $nombre_familia=>$familia){
            echo "<li>";
            echo $nombre_familia;
            echo "<ul>";
            foreach ($familia as $parentesco=>$valor){
                echo "<li>";
                if($parentesco =="Hijos"){
                    echo $parentesco.":";
                    echo "<ol>";
                    for($i = 0; $i<count($valor);$i++){
                        echo "<li>".$valor[$i]."</li>";

                    }
                    echo "</ol>";
                }else{
                    echo $parentesco.":".$valor;
                }
                echo "</li>";

            }
                echo "</ul>";
                echo "</li>";
        }
        echo "</ul>";


?>
    
</body>
</html>