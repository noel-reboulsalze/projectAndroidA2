<?php
    session_start();
    include_once 'connexion.php';
    $i="0";
    $idUser = $_SESSION['userID'];
    $indicePage = $_GET['page'];
    $provenance = $_GET['provenance'];
    $offset= 25 * $indicePage;
    switch($provenance):
        case 0:
            if($offset == 0){
                $req = $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE id_utilisateur=:id_utilisateur GROUP BY id_demande ORDER BY id_demande DESC LIMIT 25 ');
                $res= $req->execute(array(
                    'id_utilisateur'=>$idUser
                ));
            }else{
                $requete = 'SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE id_utilisateur='.$idUser.' GROUP BY id_demande ORDER BY id_demande DESC LIMIT 25 OFFSET '.$offset;
                $req= $db->query($requete);  
            }
            while($donnees = $req->fetch()){
                ?>
		            <tr>
			            <td id="date_note<?php echo $i ?>" name="date_note<?php echo $i ?>" class="historique" ><?php echo $donnees['creation_note'] ?></td>
			            <td id="montant<?php echo $i ?>" name="montant<?php echo $i ?>" class="historique" align="right" ><?php echo $donnees['total_frais'] ?> €</td>
			            <td id="statut<?php echo $i ?>" name="statut<?php echo $i ?>"class="historique" ><?php echo $donnees['etat'] ?></td>
                        <td id="n_demande<?php echo $i ?>" name="n_demande<?php echo $i ?>" align="right" class="historique" ><?php echo $donnees['id_demande'] ?></td>
                        <td id="precision<?php echo $i ?>" name="precision<?php echo $i ?>" class="historique" ><input type="button" value="Precision" onclick="precision(<?php echo $i ?>)" class="precision"/></td>
                    </tr>
			            <?php
		            $i++;
	        }
        break;
        case 1:
            if($offset == 0){
                $req = $db->query('SELECT * FROM `note_de_frais` JOIN utilisateur ON utilisateur_id=id_utilisateur WHERE etat=1 LIMIT 25');
            }else{
                $requete = 'SELECT * FROM `note_de_frais` JOIN utilisateur ON utilisateur_id=id_utilisateur WHERE etat=1 LIMIT 25 OFFSET '. $offset;
                $req = $db->query($requete);
            }
            while($donnees = $req->fetch()){
                ?><tr>
			        <td id="id_demande<?php echo $i ?>" name="id_demande<?php echo $i ?>" class="historique"><?php echo $donnees['id_demande_frais'] ?></td>
			        <td id="Td1" name="date_note<?php echo $i ?>" class="historique"><?php echo $donnees['creation_note'] ?></td>
			        <td id="nom<?php echo $i ?>" name="nom<?php echo $i ?>" class="historique"><?php echo $donnees['nom'] ?></td>
			        <td id="prenom<?php echo $i ?>" name="prenom<?php echo $i ?>" class="historique" > <?php echo $donnees['prenom'] ?></td>
			        <td align="center" id="decision<?php echo $i ?>" class="historique"><input type="button" value="Valider" onclick="decision(<?php echo $i ?>,true)"/>  <input type="button" value="Refuser" onclick="decision(<?php echo $i ?>,false)"/> <input type="button" value="Precision" onclick="precision(<?php echo $i ?>)" class="precision"/></td>
		        </tr><?php
		        $i++;
            }
        break;
    endswitch;
    if($i<25){?>
        <input type="button" value="<" onclick="getNextPage(<?php echo --$indicePage ?>,<?php echo $provenance ?>)" />
    <?php }elseif($indicePage==0){ ?>
        <input type="button" value=">" onclick="getNextPage(<?php echo ++$indicePage ?>,<?php echo $provenance ?>)" />
    <?php }else{ ?>
        <input type="button" value="<" onclick="getNextPage(<?php echo --$indicePage ?>,<?php echo $provenance ?>)" /><input type="button" value=">" onclick="getNextPage(<?php echo $indicePage+2 ?>,<?php echo $provenance ?>)" />
    <?php } 
?>