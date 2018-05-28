<?php
    session_start();
    require 'connexion.php';
    $i ="0";
    $idUser=htmlspecialchars($_GET['userID']);//a remplacer par un $_SESSION['id_utilisateur']

    //$sth = $db->prepare("SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE id_utilisateur='". $idUser . "' GROUP BY id_demande ORDER BY id_demande DESC");

   $sql = "SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE id_utilisateur='". $idUser . "' GROUP BY id_demande ORDER BY id_demande DESC";

    $resp = $db->query($sql);

    $datas = [];

    while ($row = $resp->fetch(PDO::FETCH_ASSOC)) {
    	array_push($datas, $row);
    }
    echo json_encode($datas);
	
?>