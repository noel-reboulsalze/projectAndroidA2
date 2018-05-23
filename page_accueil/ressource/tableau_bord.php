<?php include_once 'verifCompta.php'; ?>
<form name="recherche">
    <table>
        <tr>
            <td>
                <p>Selectioner l'année de création de la demande
                  <select name="setYear" id="annee" onchange="adapt(this.value)">
                      <option value="2016">2016</option>
                      <option value="2017">2017</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                  </select>
                </p>
            </td>
          </tr>
          <tr>
            <td>
              <br></br>
            </td>
          </tr>
          <tr>
            <td>
                <p>N'afficher que les demande:
                <!--<input type="radio" name="choix" value="1" onclick="afficheDemande(this.value)"/>En cours-->
                <input type="radio" name="choix" value="2" onclick="afficheDemande(this.value)"/>Validé
                <input type="radio" name="choix" value="3" onclick="afficheDemande(this.value)"/>Refusé
                <input type="radio" name="choix" value="4" onclick="afficheDemande(this.value)"/>Toutes
                </p>
            </td>
        </tr>
        <tr>
          <td>
            <br></br>
          </td>
        </tr>
        <tr>
            <td>
                <p>Selectioner le mois de création de la demande
                  <select name="setMonth" id="mois" onchange="adapt(this.value)">
                      <option value="01">01</option>
                      <option value="02">02</option>
                      <option value="03">03</option>
                      <option value="04">04</option>
                      <option value="05">05</option>
                      <option value="06">06</option>
                      <option value="07">07</option>
                      <option value="08">08</option>
                      <option value="09">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                  </select>
                </p>
            </td>
          </tr>
    </table>
</form>
<div id="affichePrecision" style="display:none"></div>

<div id="selectUser"></div>

<div id="afficheHistory"></div>
<?php
require 'connexion.php';
$req =$db->prepare('SELECT id_demande_frais, creation_note FROM note_de_frais WHERE creation_note LIKE %2016-%');
$res= $req->execute;
echo $res;
?>
<script type="text/javascript">
    function afficheDemande(choix) {
        document.getElementById('affichePrecision').style.display = "none";
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("afficheHistory").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "ressource/get_history_traite.php?choix=" + choix, true);
        xmlhttp.send();
        document.getElementById('advance').style.display = 'none';
        document.getElementById('afficheHistory').style.display = "block";
        document.getElementById('selectUser').style.display = "none";
        document.recherche.userResearch.value = "";

    }
function precision(indice) {
        var n_demande = 'n_demande' + indice;
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

    function displayNone() {
        document.getElementById('affichePrecision').style.display = "none";
    }

    function showUser() {
        document.getElementById('advance').style.display = 'block';
    }
    function annee() {
      document.getElementById('annee').style.display ='none';
    }
</script>
