<?php session_start() ?>
<script type="text/javascript" src="ressource/JavaScript1.js"></script>
<h2>
  <i>Enregistrer une nouvelle note de Frais</i>
</h2>
<form name="demandeFrais">
  <table id="tableauNote">
    <thead>
      <th style="text-align:left">Frais de:</th>
    </thead>
    <tbody>
      <tr>
        <td align="left">
          <select id="liste1" name="liste[1][]" size="1" onchange="changement(this,1)">
            <!--j'envois this en argument pour designer dynamiquement l'objet envoyé a ma function changement, qui est definit plus bas, et l'indice sert a designer mes id -->
            <option value="parking" selected="selected">Parking</option>
            <option value="transport">Transport</option>
            <option value="essence">Essence</option>
            <option value="restauration">Restauration</option>
            <option value="telephone">Téléphone</option>
            <option value="formation">Formation</option>
            <option value="reunion">Reunion</option>
            <option value="autre">Autre</option>
          </select>
          <input type="text" id="autreTexte1" name="autreTexte[1]" value="A definir" style="display:none" onfocus="clicked(this)" /> &nbsp;
        </td>
        <td>
          prix: <input type="text" id='prix1' name="prix[1]" value="" class='right' />€ &nbsp;
        </td>
        <td>
          quantité: <input type="text" name="quantite[1]" value="1" class='right' id='quantite1'/> &nbsp;
        </td>
        <td>
          <input type="file" name="justifactif[1]" value="" class='right' id="jusficatif1"/>
        </td>
      </tr>
      <tr>
        <td colspan='3'>
          <input type="button" id="addOne" name="1" value="Ajouter une note" onclick="validation(1,<?php echo $_SESSION['userID'] ?>)" />
          <input type="button" value="Supprimer une note" onclick="supprimerUne()" />
          <input type="button" id="valider" value="Enregistrer" onclick="validation(2,<?php echo $_SESSION['userID'] ?>)" />
        </td>
      </tr>
    </tbody>
  </table>
</form>
<div id="secondContener">

</div>
<script type="text/javascript">
  var nbrLignes= document.getElementById('tableauNote').rows;

  function enregistrer(userID) {
      var donneesTableau = 'ressource/add_demande.php?';
      var troll = 1;
      var longueurTableau = nbrLignes.length;
      longueurTableau -= 2;
    var idListe = 'liste' + troll;
    var idAutreTexte = 'autreTexte' + troll;
    var idPrix = 'prix' + troll;
    var idQuantite = 'quantite' + troll;
    var nameListe = 'liste[' + troll + '][]';
    var nameAutreTexte = 'autreTexte[' + troll + ']';
    var namePrix = 'prix[' + troll + ']';
    var nameQuantite = 'quantite[' + troll + ']'; //recuperation des name pour reset apres traitement 
    console.log("idListe vaut : " + idListe);
    console.log("nombre de lignes : " + longueurTableau);
    while(troll<=longueurTableau){
        document.getElementById(idListe).setAttribute("name", "liste");
        document.getElementById(idAutreTexte).setAttribute("name", "autreTexte");
        document.getElementById(idPrix).setAttribute("name", "prix");
        document.getElementById(idQuantite).setAttribute("name", "quantite"); //standardisation valeur
        console.log("tours : " +troll);
        if(document.getElementById(idListe).value=="autre"){
            donneesTableau += 'type[]='+ document.demandeFrais.autreTexte.value +'&prix[]='+ document.getElementById(idPrix).value +'&quantite[]='+ document.getElementById(idQuantite).value +'&';
        } else {
            donneesTableau += 'type[]='+ document.getElementById(idListe).value +'&prix[]='+ document.getElementById(idPrix).value +'&quantite[]='+ document.getElementById(idQuantite).value +'&';
        }

            document.getElementById(idListe).setAttribute("name", nameListe);
            document.getElementById(idAutreTexte).setAttribute("name", nameAutreTexte);
            document.getElementById(idPrix).setAttribute("name", namePrix);
            document.getElementById(idQuantite).setAttribute("name", nameQuantite);//reset valeur d'origine

            troll ++;
            idListe = 'liste' + troll;
            idAutreTexte = 'autreTexte' + troll;
            idPrix = 'prix' + troll;
            idQuantite = 'quantite' + troll;
            nameListe = 'liste[' + troll + '][]';
            nameAutreTexte = 'autreTexte[' + troll + ']';
            namePrix = 'prix[' + troll + ']';
            nameQuantite = 'quantite[' + troll + ']' //set-up passage suivant
    }
      donneesTableau += 'nbrLignes='+ longueurTableau +'&id_utilisateur='+userID; 
      console.log(donneesTableau);
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("secondContener").innerHTML = xmlhttp.responseText;
          }
      }
      xmlhttp.open("GET",donneesTableau , true);
      xmlhttp.send();
      }
    </script>