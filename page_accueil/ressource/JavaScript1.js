var i = 1;//indice d'incrementation au fil des ligne qui s'ajoutent ou des id a créer
var j = 1;
var liste = 'liste1';//pour definir dynamiquement mes id
var autreTexte = 'autreTexte1';//pareil
var numLigne = 2;//initialisation pour insérer avant les bouton mais en dessous de la ligne deja remplie, initialisé a 2 pour etre fonctionnel a la premiere utilisation
var ligne;
var colonneNote; 
var colonnePrix;
var colonneQty;
var docValidation;
var value;
var nameListeJ='liste'+j;
var nameAutreTextJ = 'autreTexte' + j;
var prixJ = 'prix' + j;
var indice = 1;

function clicked(item) { //juste pour faire disparaitre automatiquement le "a definir" dans la case quand on clique
    item.removeAttribute("value"); //redefini l'attribut envoyé de item (qui correspond a l'attribu value de item qui lui correspond a mon input sur lequel j'ai cliqué)
}

function changement(item, indice) { //la fonction qui sert a faire apparaitre/disparaitre mon input text
    if (item.value == "autre") { //je test la value du select pour savoir si je modifie ou pas
        document.getElementById("autreTexte" + indice).style.display = "";//en definissant le display a rien je fait apparaitre l'input
    } else {
        document.getElementById("autreTexte" + indice).style.display = "none";//et la logiquement c'est l'inverse
    }
}

function ajouterUne() { //pour ajouter un ligne
    i++; //incrementaion pour changer les indices de id (ici liste et autreTexte)et l'indice envoyé a la fonction changement
    ligne = document.getElementById('tableauNote').insertRow(numLigne);//là on rajoute une ligne au tableau
    colonneNote = ligne.insertCell(0);//une cellule avec en argument 0 car 0 designe la premiere cellule d'une ligne
    colonneNote.innerHTML += "<SELECT id='liste" + i + "' name='liste[" + i + "][]' size='1' onchange='changement(this," + i + ")'>\
      <OPTION   value='parking' selected='selected'>Parking</OPTION>\
      <OPTION   value='transport'>Transport</OPTION>\
      <OPTION   value='essence'>Essence</OPTION>\
      <OPTION   value='restauration'>Restauration</OPTION>\
      <OPTION   value='telephone'>Téléphone</OPTION>\
      <OPTION   value='formation'>Formation</OPTION>\
      <option   value='reunion'>Reunion</option>\
      <option   value='autre'>Autre</option>\
    </SELECT>\
    <input type='text' id='autreTexte" + i + "' name='autreTexte[" + i + "]' value='A definir' style='display:none' onclick='clicked(this)'/>"; //la j'ecris dans la cellule, \permet le retour a la ligne en spcifiant que le texte continue a la ligne
    colonnePrix = ligne.insertCell(1);//deuxieme cellule
    colonnePrix.innerHTML += "prix: <input type='text' id='prix" + i + "' name='prix[" + i + "]' value='' class='right' />€";
    colonneQty = ligne.insertCell(2);
    colonneQty.innerHTML += "quantité: <input type='text' id='quantite" + i + "' name='quantite[" + i + "]' value='1' class='right' />";
    numLigne++; //j'incremente numLigne pour ne pas ecraser ma ligne et que la suivante se crée sous la precedante
}

function supprimerUne() {
    if (numLigne == 2) {
        alert("vous ne pouvez supprimer cette ligne");
    } else {
        numLigne--;
        i--;
        j--;
        
        indice--;
        
        idListe = 'liste' + indice;
        idAutreTexte = 'autreTexte' + indice;
        idPrix = 'prix' + indice;
        idQuantite = 'quantite' + indice;
        nameListe = 'liste[' + indice + '][]';
        nameAutreTexte = 'autreTexte[' + indice + ']';
        namePrix = 'pix[' + indice + ']';
        nameQuantite = 'quantite[' + indice + ']';
        document.getElementById(idListe).setAttribute('name', nameListe);
        document.getElementById(idAutreTexte).setAttribute('name', nameAutreTexte);
        document.getElementById(idPrix).setAttribute('name', namePrix);
        document.getElementById(idQuantite).setAttribute('name', nameQuantite);
        ligne = document.getElementById('tableauNote').deleteRow(numLigne);
    }

}

function validation(fin,idUser) {

    var validé = 0;
    var idListe = 'liste' + indice;
    var idAutreTexte = 'autreTexte' + indice;
    var idPrix = 'prix' + indice;
    var idQuantite = 'quantite' + indice;
    var nameListe = 'liste[' + indice + '][]';
    var nameAutreTexte = 'autreTexte[' + indice + ']';
    var namePrix = 'pix[' + indice + ']';
    var nameQuantite = 'quantite[' + indice + ']'; //recuperation des name pour reset apres traitement

    console.log("indice validé vaut : " + indice);

    document.getElementById(idListe).setAttribute("name", "liste");
    document.getElementById(idAutreTexte).setAttribute("name", "autreTexte");
    document.getElementById(idPrix).setAttribute("name", "prix");
    document.getElementById(idQuantite).setAttribute("name", "quantite"); //standardisation des name

    docValidation = document.getElementById(idListe);
    if (docValidation.value == 'autre') {
        console.log('verification de la liste');
        value = document.demandeFrais.autreTexte.value;
        docValidation = document.getElementById(idAutreTexte);
        console.log(value);
        if (value == '') {
            console.log("verification de la valeur de autreTexte");
            console.log("autreTexte: " + value);
            alert("Vous n'avez pas precisé de quel frais il s'agissait");
        } else if (docValidation.getAttribute('value') == 'A definir') {
            console.log("verification de la valeur de autreTexte");
            alert("Vous n'avez pas precisé de quel frais il s'agissait");
        } else {
            validé += 1;
            console.log("Validé vaut: " + validé);
        }
    } else {
        validé += 1;
        console.log("Validé vaut: " + validé);
    }
    value = document.demandeFrais.prix.value;
    console.log("verification du prix");
    if(value==''){
        alert("Vous n'avez pas precisé le prix engagé");
    } else {
        validé += 1;
        console.log("Validé vaut: " + validé);
    }
    console.log(liste);
    console.log(validé);
    if (validé == 2) {
        document.getElementById(liste).setAttribute('name', nameListeJ);
        document.getElementById(autreTexte).setAttribute('name', nameAutreTextJ);
        document.getElementById(prixJ).setAttribute('name', prixJ);
        j++;
        nameListeJ = 'liste[' + j + '][]' ;
        nameAutreTextJ = 'autreTexte' + j + '][]';
        if (fin == 1) {
            ajouterUne();
            indice++;
        } else {
            enregistrer(idUser);
        }

        document.getElementById(idListe).setAttribute("name", nameListe);
        document.getElementById(idAutreTexte).setAttribute("name", nameAutreTexte);
        document.getElementById(idPrix).setAttribute("name", namePrix);
        document.getElementById(idQuantite).setAttribute("name", nameQuantite);
    }
    validé = 0;
}