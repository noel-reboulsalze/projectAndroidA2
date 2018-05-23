<?php
	require 'connexion.php';
	$id_demande= $_GET['id_demande'];
	$req = $db->prepare('SELECT * FROM frais_detail WHERE id_demande=:id_demande');
	$res = $req->execute(array(
		'id_demande'=>$id_demande,
		));
  
?>
<form name="detail_frais">
	<table class="history">
		<tr>
			<th align="center">Type de frais</th>
			<th align="center">Prix</th>
			<th align="center">Quantite</th>
			<th align="center">Total</th>
		</tr>
	<?php
	$i = 0;
	$total= 0;
	while ($donnees = $req->fetch())
	{ ?>
		<tr>
			<td name="type<?php echo $i ?>" class="historique"><?php echo $donnees['type'] ?></td>
			<td name="montant<?php echo $i ?>" class="historique"><?php echo $donnees['montant_frais'] ?></td>
			<td name="quantite<?php echo $i ?>" class="historique"><?php echo $donnees['quantite'] ?></td>
			<td name="total<?php echo $i ?>" class="historique" align="right"> <?php echo ($donnees['quantite']*$donnees['montant_frais'] ) ?> €</td>
		</tr><?php
		$i++;
		$temp = ($donnees['quantite']*$donnees['montant_frais']);
    $total = $total + $temp;
	} 
	?>
		<tr>
      <td  style="visibility: hidden"  ></td>
      <td  style="visibility: hidden"  ></td>
			<td name="total" align="right" class="historique"> Total : </td>
			<td name="total" align="right" class="historique"> <?php echo $total ?> €</td>
		</tr>
	</table>
</form>
<input type="button" value="OK" onclick="displayNone()">
