<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if($_SESSION["userType"]!='commercial'){
        if($_SESSION["userType"]=='salarie'){
            header('location: /ppe/page_accueil/utilisateur.php');
        }elseif($_SESSION["userType"]=='commercial'){
            header('location: /ppe/page_accueil/commercial.php');

    } else {
        $autorisation = true;
    }
}
?>
