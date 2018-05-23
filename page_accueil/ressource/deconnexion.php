<?php
// Pour se deconnecter on supprimer l'utilisateur de la session
// deconnexion();
session_destroy();
// On écrit un message qui doit s'afficher sur une autre page
// flashMessageEcrire("Vous êtes bien déconnecté");
$_SESSION["flashMessage"] = "Vous êtes bien déconnecté";

header("Location: ../../index.php"); ?>