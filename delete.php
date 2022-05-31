<?php
session_start();

if ( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
}

require 'functions.php';

$id = $_GET["id"];

if( delete($id) > 0 ){
    
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Delete');
    window.location.href='index.php';
    </script>");
   }   else  {
        echo ("<script LANGUAGE='JavaScript'>
         window.alert('Cant Delete');
         window.location.href='index.php';
         </script>");
     }

   


?>