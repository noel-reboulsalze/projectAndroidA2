<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if($_SESSION["userType"]!='comptable'){
        if($_SESSION["userType"]=='salarie'){
            header('location: /ppe/page_accueil/utilisateur.php');
        }elseif($_SESSION["userType"]=='admin'){
            header('location: /ppe/page_accueil/admin.php');
  
    } else {
        $autorisation = true;
    }
}
?>
