<?php session_start() ?>
<?php require 'connexion.php' ?>
<div id="affichePrecision" style="display:none">

</div>
<table  class="history">
    <thead>
        <th> Date </th>
        <th> Montant </th>
        <th> Statut </th>
        <th> N° administratif de la demande</th>
    </thead>
    <tbody id="tableContent">
        <?php
       $i = 0;
        $idUser=$_SESSION["userID"];

        $req= $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE id_utilisateur=:id_utilisateur GROUP BY id_demande ORDER BY id_demande DESC ');
        $res= $req->execute(array(
            'id_utilisateur'=>$idUser
        ));
        $data = $req->fetchAll();
        $nbReponse = count($data);
        if($nbReponse>25){
            $req = $db->prepare('SELECT SUM(quantite*montant_frais) AS total_frais, id_demande, creation_note , etat_demande.etat FROM frais_detail JOIN note_de_frais ON id_demande_frais=id_demande JOIN etat_demande ON traitement = note_de_frais.etat WHERE id_utilisateur=:id_utilisateur GROUP BY id_demande ORDER BY id_demande DESC LIMIT 25');
            $res= $req->execute(array(
            'id_utilisateur'=>$idUser
            ));
            $data=$req->fetchAll();
        }
        foreach ($data as $donnees)
	    { ?>
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
	    ?>
<?php
    if($nbReponse>25){ ?>
    <tr>
        <td id="navPage" >
                <input type="button" value=">" onclick="getNextPage(1)" />
        </td>
    </tr>
<?php } ?>
    </tbody>
</table>

        
<script type="text/javascript">
    function precision(indice){
        var n_demande = 'n_demande'+indice;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("affichePrecision").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","ressource/get_precision.php?indice="+indice+"&id_demande="+document.getElementById(n_demande).textContent,true);
        xmlhttp.send();
        document.getElementById('affichePrecision').style.display ="block";
    }
    
    function getNextPage(indice){
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("tableContent").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","ressource/get_next_page.php?page="+indice+"&provenance=0",true);
        xmlhttp.send();
    }
    
    function displayNone(){
        document.getElementById('affichePrecision').style.display ="none";
    }
</script>
