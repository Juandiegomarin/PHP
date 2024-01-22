<?php
session_name("ejercicio03_2023-2024");
session_start();

if(isset($_POST["cambiar"])){

    if(!isset($_SESSION["resultado"]))
    $_SESSION["resultado"]=0;

    if($_POST["cambiar"]=="-"){
        $_SESSION["resultado"]-=1;
    }else if($_POST["cambiar"]=="+"){
        $_SESSION["resultado"]+=1;
    }else{
        session_destroy();
    }

    header("Location:Sesiones03_1.php");
    exit();

}
?>