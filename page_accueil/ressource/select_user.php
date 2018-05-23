<?php
include_once 'verifCompta.php';
require 'connexion.php';
$nameUser=$_GET['nameUser'];
$choix=$_GET['choix'];
if($choix==4){
    $req=$db -> prepare('SELECT utilisateur_id, nom, prenom FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat JOIN utilisateur ON note_de_frais.id_utilisateur=utilisateur.utilisateur_id WHERE utilisateur.nom = :nom && (note_de_frais.etat=2 || note_de_frais.etat=3) GROUP BY utilisateur_id ORDER BY creation_note DESC');
    $res=$req -> execute(array(
    'nom'=>$nameUser,
    ));
}else{
    $req=$db -> prepare('SELECT utilisateur_id, nom, prenom FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat JOIN utilisateur ON note_de_frais.id_utilisateur=utilisateur.utilisateur_id WHERE utilisateur.nom = :nom && note_de_frais.etat=:etat GROUP BY utilisateur_id ORDER BY creation_note DESC');
    $res=$req -> execute(array(
        'nom'=>$nameUser,
        'etat'=>$choix
        ));
}
$i=0;
$donnees = $req->fetchAll();
foreach ($donnees as $row){
    $i++;
}
if($i==0){
    if(isset($idDemande)){
        echo 'Semblerait la note recherchée n\'éxiste pas ';
    } else {
        echo "Manifestement soit le nom de l'utilisateur rentré n'est pas bon, soit il ne depense rien, soit ses demande sont toujour en attente";
    }
}
if($i==1){
    echo $i;
    include 'get_history_traite.php';
}else{
    echo "Semblerait-il qu'il y ai plus d'un utilisateur portant le nom de ".$nameUser.", Veuiller selectionner l'utilisateur que vous recherchez dans la liste: "; ?>
    <table>
    <?php
    foreach($donnees as $row){ ?>
    
        <tr>
            <td><?php echo $row['nom'] ?></td>
            <td><?php echo $row['prenom'] ?></td>
            <td><input type="button" value="Celui-ci" onclick="researchById(<?php echo $row['utilisateur_id'] ?>)"</td>
        </tr>
        <?php
    }?>
    </table>
<?php
}
?>