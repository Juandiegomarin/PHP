<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Mi Primera web<p>
        <?php
        echo "<p>Hola a todos</p>";

        $a =8;
        $b =9;
        $c =$a + $b;

        echo"<p>El resultado de sumar ".$a." + ".$b." es : ".$c."</p>";
        if(3>$c)
        {
            echo "<p>Si</p>";

        }
        else
        {
            echo "<p>No</p>";
        }

        switch($c){

            case 1: $c=$a-$b;
                break;
            
            case 2: $c=$a/$b;
                    break;
            case 3: $c=$a*$b;
                        break;
              


            default:$c=$a+$b;
        }

        echo "<p>El resultado del switch es: ".$c."</p>";
        echo"<p>For</p>";
        for($i=0;$i<8;$i++){

            echo"<p>".($i+1)."</p>";
        }
        $i=0;

        echo"<p>-----------------------------------------</p>";
        echo"<p>While</p>";
        
        
        while($i<8){

            echo"<p>".($i+1)."</p>";
            $i++;
        }

    ?>

</body>
</html>