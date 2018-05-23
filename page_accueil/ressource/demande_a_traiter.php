<div id="affichePrecision" style="z-index:2;display='inline block'">

</div>
<?php
    include_once 'verifCompta.php';
	require 'connexion.php';
	//ecriture de la demande SQL
	$req = $db->query('SELECT * FROM `note_de_frais` JOIN utilisateur ON utilisateur_id=id_utilisateur WHERE etat=1');
	//recuperation donnée dans un tableau
	?>
	<form name="demande_a_traiter" >
	<table class="history" >
        <thead>
			<th align="center">N° demande</th>
			<th align="center">Date de la demande</th>
			<th align="center">Nom utilisateur</th>
			<th align="center">Prenom utilisateur</th>
        </thead>
        <tbody id="tableContent">
        <?php        
	$i = 0;
    $data = $req->fetchAll();
    $nbReponse = count($data);
    if($nbReponse>25){
        $req = $db->query('SELECT * FROM `note_de_frais` JOIN utilisateur ON utilisateur_id=id_utilisateur WHERE etat=1 LIMIT 25');
        $data=$req->fetchAll();
    }
    foreach ($data as $donnees)
	{ ?>
		<tr>
			<td id="id_demande<?php echo $i ?>" name="id_demande<?php echo $i ?>" class="historique"><?php echo $donnees['id_demande_frais'] ?></td>
			<td id="date_note<?php echo $i ?>" name="date_note<?php echo $i ?>" class="historique"><?php echo $donnees['creation_note'] ?></td>
			<td id="nom<?php echo $i ?>" name="nom<?php echo $i ?>" class="historique"><?php echo $donnees['nom'] ?></td>
			<td id="prenom<?php echo $i ?>" name="prenom<?php echo $i ?>" class="historique"><?php echo $donnees['prenom'] ?></td>
			<td align="center" id="decision<?php echo $i ?>" class="historique"><input type="image" src="./ressource/boutonValider.png" onclick="decision(<?php echo $i ?>,true)" width="44px" height="44px"/><input type="image" src="./ressource/boutonRefus.png" onclick="decision(<?php echo $i ?>,false)" width="44px" height="44px"/> <input type="button" value="Precision" onclick="precision(<?php echo $i ?>)" class="precision" height="100%"/></td>
		</tr><?php
		$i++;
	} 
    if($nbReponse>25){ ?>
    <tr>
        <td id="navPage" >
                <input type="button" value=">" onclick="getNextPage(1)" />
        </td>
    </tr>
<?php } ?>
    </tbody>
	</table>
	</form><?php
?>

<script type="text/javascript">
	function decision(indice, decision){
		var decisionN = 'decision'+indice;
		var idDemande = 'id_demande'+indice;
		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
		if(decision){
			document.getElementById(decisionN).innerHTML = "<img src='ressource/valide.png' width='44px' height='44px'/>";
		}else{
			document.getElementById(decisionN).innerHTML = "<img src='ressource/refus.png' width='44px' height='44px'/>";
		}
		xmlhttp.open("GET","ressource/change_state.php?id_demande="+document.getElementById(idDemande).textContent+"&decision="+decision+"&decisionN="+decisionN,true);
        xmlhttp.send();
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
        xmlhttp.open("GET","ressource/get_next_page.php?page="+indice+"&provenance=1",true);
        xmlhttp.send();
    }

	function precision(indice) {
        var n_demande = 'id_demande' + indice;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("affichePrecision").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "ressource/get_precision.php?indice=" + indice + "&id_demande=" + document.getElementById(n_demande).textContent, true);
        xmlhttp.send();
        document.getElementById('affichePrecision').style.display = "block";
    }

	function displayNone(){
		document.getElementById('affichePrecision').style.display ="none";
	}
</script>
