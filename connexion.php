<?php
try
	{
		$db = new PDO('mysql:host=localhost;dbname=project_android;charset=utf8', 'reboul', '');
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
?>
