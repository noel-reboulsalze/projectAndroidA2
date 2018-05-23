<?php
include_once 'verifCompta.php';
 require 'connexion.php';
 if(isset($_GET['idDemande'])){
     $idDemande=$_GET['idDemande'];
     $req= $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note, etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat JOIN utilisateur ON note_de_frais.id_utilisateur=utilisateur.utilisateur_id WHERE id_demande=:id');
     $res= $req->execute(array(
         'id' =>$idDemande
         ));
 } else {
     if(!isset($nameUser)){
         if(isset($_GET['nameUser'])){
             $nameUser=$_GET['nameUser'];
         }
     } 
     if(!isset($choix)){
         $choix=$_GET['choix'];
     }
     if(isset($_GET['idUser'])){
         $idUser = $_GET['idUser'];
         if($choix == 4){
             $req= $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note, etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat JOIN utilisateur ON note_de_frais.id_utilisateur=utilisateur.utilisateur_id WHERE utilisateur.utilisateur_id = :idUser && note_de_frais.etat=2 || note_de_frais.etat=3 GROUP BY id_demande ORDER BY creation_note DESC ');
             $res= $req->execute(array(
                 'idUser' =>$idUser
                 ));
         }else {
             $req= $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat JOIN utilisateur ON note_de_frais.id_utilisateur=utilisateur.utilisateur_id WHERE utilisateur.utilisateur_id = :idUser && note_de_frais.etat=:etat GROUP BY id_demande ORDER BY creation_note DESC ');
             $res= $req->execute(array(
                    'idUser' =>$idUser,
                    'etat'=>$choix
                ));
         }     
     }else{
         if(isset($nameUser)){
             if($choix == 4){
                 $req= $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note, etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat JOIN utilisateur ON note_de_frais.id_utilisateur=utilisateur.utilisateur_id WHERE utilisateur.nom = :nom && (note_de_frais.etat=2 || note_de_frais.etat=3) GROUP BY id_demande ORDER BY creation_note DESC ');
                 $res= $req->execute(array(
                     'nom' =>$nameUser
                     ));
             }else {
                 $req= $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat JOIN utilisateur ON note_de_frais.id_utilisateur=utilisateur.utilisateur_id WHERE utilisateur.nom = :nom && note_de_frais.etat=:etat GROUP BY id_demande ORDER BY creation_note DESC ');
                 $res= $req->execute(array(
                        'nom' =>$nameUser,
                        'etat'=>$choix
                    ));
             }     
         }else{
             if($choix == 4){
                 $req= $db->query('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE note_de_frais.etat=2 || note_de_frais.etat=3 GROUP BY id_demande ORDER BY creation_note DESC');
             }else {
                 $req= $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE note_de_frais.etat=:etat GROUP BY id_demande ORDER BY creation_note DESC ');
                 $res= $req->execute(array(
                        'etat'=>$choix
                    ));
             }
         }
     }
 }
 if(isset($idDemande)){ ?>
    <table class="history">
        <thead>
            <th>n° de la demande</th>
            <th>Date</th>
             <th>etat</th>
            <th>montant</th>

        </thead>
        <?php } else { ?>
    <table class="history">
        <thead>
            <th>n° de la demande</th>
            <th>Date</th>
            <?php
     if($choix==4){ ?>
             <th>etat</th>
            <?php } ?>
            <th>montant</th>

        </thead>
     <?php }
     $total=0;
     $i = 0;
     $donnees = $req->fetchAll();
     foreach($donnees as $row)
     { ?>
		        <tr>
                    <td id="n_demande<?php echo $i ?>" name="n_demande<?php echo $i ?>" align="left" class="historique" ><?php echo $row['id_demande'] ?></td>
			        <td id="date_note<?php echo $i ?>" name="date_note<?php echo $i ?>" class="historique" ><?php echo $row['creation_note'] ?></td>
			        <?php
                    if(isset($idDemande)){ ?>
                        <td id="statut" name="statut"class="historique" ><?php echo $row['etat'] ?></td>
                    <?php } else {
                        if($choix==4){ ?>
                        <td id="statut<?php echo $i ?>" name="statut<?php echo $i ?>"class="historique" ><?php echo $row['etat'] ?></td>
                    <?php } 
                    }?>
                    <td id="montant<?php echo $i ?>" name="montant<?php echo $i ?>" class="historique" align="right" ><?php echo $row['total_frais'] ?> €</td>
			        <td id="precision<?php echo $i ?>" name="precision<?php echo $i ?>" class="historique" ><input type="image" src="./ressource/more.png" onclick="precision(<?php echo $i ?>)" class="precision" width="44px" height="44px"/></td>
                </tr>
			        <?php
         $total= $total+$row['total_frais'];
         $i++;
     } 

     if($i==0&&isset($nameUser)){
         echo "Manifestement l'utilisateur ne depense pas beaucoup! ou ses demandes ne ont pas encore traitée";   
     } else {
         if(isset($choix)){
             if($choix==2){ ?>
            <tr>
                <td  style="visibility: hidden"  ></td>
			    <td name="total" align="right" class="historique"> Total : </td>
			    <td name="total" align="right" class="historique"> <?php echo $total ?> €</td>
            </tr>
        <?php }
         }
     }?>
 </table>