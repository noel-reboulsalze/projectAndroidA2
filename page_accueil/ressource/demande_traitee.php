<?php include_once 'verifCompta.php'; ?>
<form name="recherche">
    <table>
        <tr>
            <td>
                <p>N'afficher que les demande: 
                <input type="radio" name="choix" value="2" onclick="afficheDemande(this.value)"/>Validé
                <input type="radio" name="choix" value="3" onclick="afficheDemande(this.value)"/>Refusé
                <input type="radio" name="choix" value="4" onclick="afficheDemande(this.value)"/>Toutes
                <input type="radio" name="choix" value="1" onclick="showUser()"/>Recherche avancée
                </p> 
            </td>
        </tr>
        <tr id="advance" style="display: none">
            <td>
                <select name="setResearch" onchange="adapt(this.value)">
                    <option value="byName">nom de l'utilisateur:</option>
                    <option value="byIdDemande">n° de la demande:</option>
                </select>
                <input type="text" name="userResearch" id="userName" value="" />
            </td>
            <td id="advanceChoice">
                <input type="radio" name="advanceChoix" value="2" id="premierBouttonA"/>Validé
                <input type="radio" name="advanceChoix" value="3" id="secondBouttonA"/>Refusé
                <input type="radio" name="advanceChoix" value="4" id="troisiemeBouttonA"/>Toutes
            </td>
            <td>
                <input type="button" name="research" value="Rechercher" onclick="redirect()" />
            </td>
        </tr>
    </table>
</form>
<div id="affichePrecision" style="display:none"></div>

<div id="selectUser"></div>

<div id="afficheHistory"></div>

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

    function redirect() {
        document.getElementById('affichePrecision').style.display = "none";
        if (document.recherche.setResearch.value == 'byName') {
            selectByUser();
        } else {
            selectByIdDemande();
        }
    }

    function selectByIdDemande() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("selectUser").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "ressource/get_history_traite.php?idDemande=" + document.recherche.userResearch.value, true);
        xmlhttp.send();
        document.getElementById('afficheHistory').style.display = "none";
        document.getElementById('selectUser').style.display = "block";
    }

    function selectByUser() {
        if (document.getElementById('premierBouttonA').checked) {
            var valeur = document.recherche.advanceChoix.value;
        } else {
            if (document.getElementById('secondBouttonA').checked) {
                var valeur = document.recherche.advanceChoix.value;
            } else {
                if (document.getElementById('troisiemeBouttonA').checked) {
                    var valeur = document.recherche.advanceChoix.value;
                }
            }
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("selectUser").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "ressource/select_user.php?choix=" + valeur + "&nameUser=" + document.recherche.userResearch.value, true);
        xmlhttp.send();
        document.getElementById('afficheHistory').style.display = "none";
        document.getElementById('selectUser').style.display = "block";
    }

    function researchById(id) {
        if (document.getElementById('premierBouttonA').checked) {
            var valeur = document.recherche.advanceChoix.value;
        } else {
            if (document.getElementById('secondBouttonA').checked) {
                var valeur = document.recherche.advanceChoix.value;
            } else {
                if (document.getElementById('troisiemeBouttonA').checked) {
                    var valeur = document.recherche.advanceChoix.value;
                }
            }
        }

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
        xmlhttp.open("GET", "ressource/get_history_traite.php?choix=" + valeur + "&idUser=" + id, true);
        xmlhttp.send();
        document.getElementById('afficheHistory').style.display = "block";
        document.getElementById('selectUser').style.display = "none";
    }

    function adapt(choix) {
        if (choix == "byName") {
            document.getElementById('advanceChoice').style.display = "table-cell";
        } else {
            document.getElementById('advanceChoice').style.display = "none";
        }
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
</script>