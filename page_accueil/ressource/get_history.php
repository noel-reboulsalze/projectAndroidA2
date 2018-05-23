<?php
    session_start();
    require 'connexion.php';
    $i ="0";
    $idUser=$_SESSION['userID'];//a remplacer par un $_SESSION['id_utilisateur']

    $req= $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE id_utilisateur=:id_utilisateur GROUP BY id_demande ORDER BY id_demande DESC ');
    $res= $req->execute(array(
        'id_utilisateur'=>$idUser
    ));
    $nbReponse = count($req->fetch_all());
    var_dump($nbReponse);

    while ($donnees = $req->fetch())
	{ ?>
		<tr>
			<td id="date_note<?php echo $i ?>" name="date_note<?php echo $i ?>" class="historique" ><?php echo $donnees['creation_note'] ?></td>
			<td id="montant<?php echo $i ?>" name="montant<?php echo $i ?>" class="historique" align="right" ><?php echo $donnees['total_frais'] ?> €</td>
			<td id="statut<?php echo $i ?>" name="statut<?php echo $i ?>"class="historique" ><?php echo $donnees['etat'] ?></td>
            <td id="n_demande<?php echo $i ?>" name="n_demande<?php echo $i ?>" align="right" class="historique" ><?php echo $donnees['id_demande'] ?></td>
        </tr>
			<?php
		$i++;
	} 
	?>
?>