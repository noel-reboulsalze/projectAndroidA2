<?php
	require 'connexion.php';
    include_once 'verifCompta.php';
	$id_demande = $_GET['id_demande'];
	$decision = $_GET['decision'];
  $decisionN = $_GET['decisionN'];
	
	$req = $db->prepare('UPDATE note_de_frais SET etat = :decision WHERE id_demande_frais=:id_demande');
	
	if($decision=='true'){
		$result=$req->execute(array(
		'decision' => '2',
		'id_demande' => $id_demande,
		));
    }else{
		$result=$req->execute(array(
		'decision' => '3',
		'id_demande' => $id_demande,
		));
	}
?>