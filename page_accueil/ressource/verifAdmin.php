<?php
    if(!isset($_SESSION)){
            session_start();
    }
    if($_SESSION["userType"]!='admin'){
        if($_SESSION["userType"]=='salarie'){
            header('location: /ppe/page_accueil/utilisateur.php');
        }elseif($_SESSION["userType"]=='comptable'){
            header('location: /ppe/page_accueil/comptable.php');
        }
    }else {
        $autorisation = true;
    }
?>