<?php include_once 'verifAdmin.php' ?>
<h2><i>Nouveaux Membres</i></h2>
<form name="ajoutMembre" >
            <table>
				<tr>
					<td> Type:</td>
					<td>Salarié  : <input type="radio" name="type" value="salarie"></br>
						Comptable  : <input type="radio" name="type" value="comptable"></br>
						Administrateur  : <input type="radio" name="type" value="admin"></br>
				</tr>
                <tr>
                    <td align="left">Login:</td>
                    <td align="left"><input type="text" name="login" id="login" /></td>
                </tr>
                <tr>
                    <td align="left">Nom:</td>
                    <td align="left"><input type="text" name="nom" id="nom"/></td>
                </tr>
                <tr>
                    <td align="left">Prénom:</td>
                    <td align="left"><input type="text" name="prenom" id="prenom"/></td>
                </tr>
                <tr>
                    <td align="left">Mot de passe:</td>
                    <td align="left"><input type="password" name="password" id="password"/></td>
                </tr>
                <tr>
                    <td align="left">Répéter:</td>
                    <td align="left"><input type="password" name="repeat" id="repeat"/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="button" value="Validé" onclick="" id="secondPage" />
                    </td>
                </tr>
            </table>
</form>
<div class="secondContener">
</div>
<script type="text/javascript">
    var donneesTableau='';
      $('#secondPage').click(function() {
          $('.secondContener').fadeOut(500, function() {
            donneesTableau = 'ressource/add_user.php?type='+document.ajoutMembre.type.value+'&login='+document.ajoutMembre.login.value+'&nom='+document.ajoutMembre.nom.value+'&prenom='+document.ajoutMembre.prenom.value+'&password='+document.ajoutMembre.password.value+'&repeat='+document.ajoutMembre.repeat.value; // variable utilisé pour contenir l'url
          $(this).load(donneesTableau).fadeIn(500);
        });
    });
</script>
