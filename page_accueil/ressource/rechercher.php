<?php include_once 'verifAdmin.php' ?>
<html>
<head>
  <script>
    $(document).ready(function(){
      $('#recherche').click(function(){
        $.post('./ressource/get_user.php',{'nom':$('#nom').val(),'prenom':$('#prenom').val(),'type':$('#type').val()},
        function(users){
          $('#user').html('');
          users.forEach(function(user,index){
            $('#user').append('<tr>'+
              '<td id="nom'+index+'" name="nom'+index+'" class="historique" align="center">'+user.nom+'</td>'+
              '<td id="prenom'+index+'" name="prenom'+index+'" class="historique" align="center">'+user.prenom+'</td>'+
              '<td id="type'+index+'" name="type'+index+'"class="historique" align="center">'+user.type+'</td>'+
           '</tr>')
          })
        },
        'json')
      });
    });
  </script>
</head>
<body>
<h2><i>Rechercher Utilisateurs</i></h2>
<form name="rechercher">
                <tr>
                    <td align="left">Nom:</td>
                    <td align="left"><input type="text" name="nom" id="nom"/></td>
                </tr>
                <tr>
                    <td align="left">Prénom:</td>
                    <td align="left"><input type="text" name="prenom" id="prenom"/></td>
                </tr>
                <tr>
                    <td align="left">Type:</td>
                        <select name="recherche_user" id="type">
                            <option value="salarie" id="salarie">salarie</option>
                            <option value="admin" id="admin">administrateur</option>
                            <option value="comptable" id="comptable">comptable</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left"><input type="button" name="recherche" id="recherche" value="Rechercher"/></td>
                </tr>

</form>
<?php
include_once 'verifAdmin.php';
require 'connexion.php';
$i ="0";

$req= $db->prepare('SELECT nom, prenom, type FROM utilisateur');
$res= $req->execute();

?>
<center><table>
  <thead>
    <th>Nom</th>
    <th>Prenom</th>
    <th>Type</th>
  </thead>
  <tbody id="user">
 <?php while ($donnees = $req->fetch())
{ ?>
 <tr>
   <td id="nom<?php echo $i ?>" name="nom<?php echo $i ?>" class="historique" align="center"><?php echo $donnees['nom'] ?></td>
   <td id="prenom<?php echo $i ?>" name="prenom<?php echo $i ?>" class="historique" align="center"><?php echo $donnees['prenom'] ?> </td>
   <td id="type<?php echo $i ?>" name="type<?php echo $i ?>"class="historique" align="center"><?php echo $donnees['type'] ?></td>
</tr>
   <?php
 $i++;
}
?>
</tbody>
</table></center>
  </body>
</html>
