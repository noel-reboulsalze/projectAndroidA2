<?php 	include_once 'verifAdmin.php';
		include_once 'connexion.php'; ?>
<div onload="reset()"><?php
if($autorisation){ 
// On commence par récupérer les champs 
if(isset($_GET['nom']))      $nom=$_GET['nom'];
else      $nom="";

if(isset($_GET['prenom']))      $prenom=$_GET['prenom'];
else      $prenom="";

if(isset($_GET['type']))      $type=$_GET['type'];
else      $type="";

if(isset($_GET['login']))      $login=$_GET['login'];
else      $login="";

if(isset($_GET['password']))      $password=$_GET['password'];
else      $password="";

if(isset($_GET['repeat']))      $repeat=$_GET['repeat'];
else      $repeat="";

// On vérifie si les champs sont vides 
if(empty($nom) OR empty($prenom) OR empty($type) OR empty($login) OR empty($password) OR empty($repeat)) 
    { 
    echo '<font color="red">Attention, TOUT les champs sont obligatoire !</font>'; 
    } 

// Aucun champ n'est vide, on peut enregistrer dans la table 

else if($password == $repeat){
       // connexion à la base voir include_once
	

    // on écrit la requête sql 
    $req = $db->prepare('INSERT INTO utilisateur(nom, prenom, type, login, password) VALUES( :nom, :prenom, :type, :login, :password)');
	$req->execute(array(
	'nom' => $nom,
	'prenom' => $prenom,
	'type' => $type,
	'login' => $login,
	'password' => $password
	));

    // on affiche le résultat pour le visiteur 
    echo 'Vos infos on été ajoutées.'; 

    } else {
		echo 'Les mots de passe differe!';
	}
	}	
?></div>
<script type="text/javascript">
  function reset(){
    document.getElementById('nom').setAttribute('value','');
  }
</script>