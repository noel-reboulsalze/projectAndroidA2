<?php 
    session_start();
    if(isset(json_decode(file_get_contents('php://input'),true)['type']))      
        $type=json_decode(file_get_contents('php://input'),true)['type'];
    else      $type='';

    if(isset(json_decode(file_get_contents('php://input'),true)['prix']))      
        $prix=json_decode(file_get_contents('php://input'),true)['prix'];
    else      $prix='';

    if(isset(json_decode(file_get_contents('php://input'),true)['quantite']))      
        $quantite=json_decode(file_get_contents('php://input'),true)['quantite'];
    else      $quantite='';

    $id_utilisateur=json_decode(file_get_contents('php://input'),true)["userID"]; //sera a remplacer par un $_SESSION

// On vérifie si les champs sont vides 
if(empty($type) OR empty($prix) OR empty($quantite)) { 
    echo '<font color="red">Attention, TOUS les champs sont obligatoire !</font>'; 
    
    
} 



else {
    // On verifie que les chiffre en sont bien
        $validPrix= filter_var($prix, FILTER_VALIDATE_FLOAT);
        if(!$validPrix){
            echo "<font color='red'>POUR LE PRIX, DES CHIFFRES SVP!(en ligne".($i+1).")</font>";
            die;
        }
        $validQuantite= filter_var($quantite, FILTER_VALIDATE_INT);
        if(!$validQuantite){
            echo "<font color='red'>POUR LA QUANTITE, DES CHIFFRES ENTIER SVP!(en ligne".($i+1).")</font>";
            die;
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
	    $result = $req2->execute(array(
	    'id_demande' => $row['id_demande_frais'],
	    'quantite' => $quantite,
        'montant_frais' => $prix,
        'type' => $type));
        if(!$result) var_dump($req2->errorInfo());
    }
//if(!$result) var_dump($req2->errorInfo());
 
?>