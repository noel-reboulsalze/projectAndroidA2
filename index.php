<?php include_once './includes/fonctions.php'; ?>
<?php include_once './includes/config.php'; ?>
<?php

// On teste si l'utilisateur a validé le formulaire
if (isset(json_decode(file_get_contents('php://input'),true)['login']) 
    && isset(json_decode(file_get_contents('php://input'),true)['pass'])) {
    $login = json_decode(file_get_contents('php://input'),true)["login"];
    $pass = json_decode(file_get_contents('php://input'),true)["pass"];
    $message = "";
    $link = mysqli_connect_utf8(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
    // Problème de sécurité : Injection SQL
    // login et pass viennent de l'extérieur et finissent dans une requete SQL
    // donc mysqli_escape_string
    $login = mysqli_escape_string($link, $login);
    $pass = mysqli_escape_string($link, $pass);
    $salt = PASSWORD_SALT;

    // on selectionne ALL depuis l'utilisateur ou se trouve le login
    $sql = "SELECT login,type,utilisateur_id FROM utilisateur WHERE login = '$login' AND password = '$pass'";
    $result = mysqli_query($link, $sql);

    $membre = mysqli_fetch_assoc($result);
    mysqli_close($link);
    if ($membre === null) {
        $message = "Mauvais login/pass";  
        http_response_code(404);
    } else {
        // On enregistre dans la session le login de l'utilisateur qui s'est connecté
        // TODO
        // seConnecter($membre["login"]);
        $_SESSION["userConnected"] = $membre["login"];
        $_SESSION["userID"] = $membre["utilisateur_id"];
        $_SESSION["userType"] = $membre["type"];

        echo json_encode($membre);

        // Si on vient d'une page sécurisée
        // on redirige vers la page d'origine
        // TODO
        // if(containsSecuredPage()) {
        //     $page = securedPage();
        // }
        if (isset($_SESSION["securedPage"])) {
            unset($_SESSION["securedPage"]);
        } else {
            // Sinon on redirigera vers l'index avec un message
            //            $page = "utilisateur.php";

            if ($_SESSION["userType"] == "comptable") {
                //header("Location: page_accueil/comptable.php");
            } else if ($_SESSION["userType"] == "admin") {
                //header("Location: page_accueil/admin.php");
            } else if ($_SESSION["userType"] == "salarie") {
                //header("Location: page_accueil/utilisateur.php");
            } else if ($_SESSION["userType"] == "commercial") {
                //header("Location: page_accueil/commercial.php");
            }
            //            $page = "admin.php";
            // todo
//             flashMessageEcrire("Bienvenue $membre[login], vous êtes connecté");
        }

        exit();
    }
} else {
    http_response_code(500);
} ?>