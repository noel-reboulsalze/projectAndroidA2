<?php
require 'connexion.php';


// isset = regarder si la varible est set (existe)
//varible nom prenom type rentrer en post dans le formulaire html
//? = vrai
//: = faux
//ternaire conditions, vrai, faux
/*((isset($_POST['nom']))?'nom='.$_POST['nom'].(((isset($_POST['prenom'])) || (isset($_POST['type'])))?' AND ':''):''.
((isset($_POST['prenom']))?'prenom='.$_POST['prenom'].((isset($_POST['type']))?' AND ':''):''.
((isset($_POST['type']))?'type='.$_POST['type']:'')));*/

$request = 'SELECT nom, prenom, type FROM utilisateur WHERE ';

if(!empty($_POST['nom'])){
  $request .='nom="'.$_POST['nom'].'" AND ';
}
if(!empty($_POST['prenom'])){
  $request .= 'prenom="'.$_POST['prenom'].'" AND ';
}
$request.= 'type="'.$_POST['type'].'"';

$req = $db->query($request);
if(!$req)
  var_dump($req->errorInfo);
else{
  $res=[];
  while ($data=$req->fetch()) {
    $res[]=[
      'nom'=>$data['nom'],
      'prenom'=>$data['prenom'],
      'type'=>$data['type']
    ];
  }
  echo json_encode($res);
}
