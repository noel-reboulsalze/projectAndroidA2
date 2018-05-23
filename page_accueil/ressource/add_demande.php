<?php 
    session_start();
    if(isset($_GET['type']))      $type=$_GET['type'];
    else      $type='';

    if(isset($_GET['prix']))      $prix=$_GET['prix'];
    else      $prix='';

    if(isset($_GET['quantite']))      $quantite=$_GET['quantite'];
    else      $quantite='';

    $id_utilisateur=$_SESSION["userID"]; //sera a remplacer par un $_SESSION

    $nbrLignes=$_GET['nbrLignes'];

// On vérifie si les champs sont vides 
if(empty($type) OR empty($prix) OR empty($quantite)) { 
    echo '<font color="red">Attention, TOUS les champs sont obligatoire !</font>'; 
    
    
} 



else {
    // On verifie que les chiffre en sont bien
    for($i = 0 ; $i < $nbrLignes ; $i++){
        $validPrix= filter_var($prix[$i], FILTER_VALIDATE_FLOAT);
        if(!$validPrix){
            echo "<font color='red'>POUR LE PRIX, DES CHIFFRES SVP!(en ligne".($i+1).")</font>";
            die;
        }
        $validQuantite= filter_var($quantite[$i], FILTER_VALIDATE_INT);
        if(!$validQuantite){
            echo "<font color='red'>POUR LA QUANTITE, DES CHIFFRES ENTIER SVP!(en ligne".($i+1).")</font>";
            die;
        }
    }
    // Aucun champ n'est vide et les chiffres en sont bien, on peut enregistrer dans la table 
       // connexion à la base
	include_once 'connexion.php';

    // on écrit la requête sql pour créer la note
    $req = $db->prepare('INSERT INTO note_de_frais(id_utilisateur) VALUES( :id_utilisateur)');
	$req->execute(array(
	'id_utilisateur' => $id_utilisateur,
	));

    $req = $db->prepare('SELECT id_demande_frais FROM note_de_frais WHERE id_utilisateur=:id_utilisateur ORDER BY id_demande_frais DESC');
	$result = $req->execute(array(
	'id_utilisateur' => $id_utilisateur,
	));
    $row = $req->fetch(PDO::FETCH_ASSOC);

    //  on écrit la requête sql pour rentrer le contenu de la note
    $req2 = $db->prepare('INSERT INTO frais_detail(id_demande, quantite, montant_frais, type) VALUES( :id_demande, :quantite, :montant_frais, :type)');
//if(!$req2) var_dump($req2->errorInfo());
    for($i = 0; $i < $nbrLignes; $i++){
	    $result = $req2->execute(array(
	    'id_demande' => $row['id_demande_frais'],
	    'quantite' => $quantite[$i],
        'montant_frais' => $prix[$i],
        'type' => $type[$i]
        ));
        if(!$result) var_dump($req2->errorInfo());
    }
//if(!$result) var_dump($req2->errorInfo());

    // on affiche le résultat pour le visiteur 
    $message='Vos infos ont été ajoutées.';
    echo filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS); 

} 
?>