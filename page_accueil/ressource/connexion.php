<?php
try
	{
		$db = new PDO('mysql:host=localhost;dbname=projectweb;charset=utf8', 'reboul', '');
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
?>
