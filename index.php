<?php include_once './includes/fonctions.php'; ?>
<?php include_once './includes/config.php'; ?>
<?php
// On teste si l'utilisateur a validé le formulaire
if (isset($_POST["login"], $_POST["pass"])) {
    $login = $_POST["login"];
    $pass = $_POST["pass"];
    $message = "";
    $link = mysqli_connect_utf8(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
    // Problème de sécurité : Injection SQL
    // login et pass viennent de l'extérieur et finissent dans une requete SQL
    // donc mysqli_escape_string
    $login = mysqli_escape_string($link, $login);
    $pass = mysqli_escape_string($link, $pass);
    echo(json_encode($login));
    echo(json_encode($pass));
    $salt = PASSWORD_SALT;

    // on selectionne ALL depuis l'utilisateur ou se trouve le login
    $sql = "SELECT login,type,utilisateur_id FROM utilisateur WHERE login = '$login' AND password = '$pass'";
    $result = mysqli_query($link, $sql);

    $membre = mysqli_fetch_assoc($result);
    mysqli_close($link);

    if ($membre === null) {
        $message = "Mauvais login/pass";
    } else {
        // On enregistre dans la session le login de l'utilisateur qui s'est connecté
        // TODO
        // seConnecter($membre["login"]);
        $_SESSION["userConnected"] = $membre["login"];
        $_SESSION["userID"] = $membre["utilisateur_id"];
        $_SESSION["userType"] = $membre["type"];

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

            echo $_SESSION["userType"];
            if ($_SESSION["userType"] == "comptable") {
                header("Location: page_accueil/comptable.php");
            } else if ($_SESSION["userType"] == "admin") {
                header("Location: page_accueil/admin.php");
            } else if ($_SESSION["userType"] == "salarie") {
                header("Location: page_accueil/utilisateur.php");
            } else if ($_SESSION["userType"] == "commercial") {
                header("Location: page_accueil/commercial.php");
            }
            //            $page = "admin.php";
            // todo
//             flashMessageEcrire("Bienvenue $membre[login], vous êtes connecté");
        }

        exit();
    }
} ?>

<LINK rel="stylesheet" type="text/css" href="connexion.css">

<form method="post">
    <div id="formulaire">
    <form>
      <table>
        <?php if(isset($message)){?>
        <tr>
            <td colspan=2 ><font color="red"><?php echo $message ?></font></td>
        </tr>
        <?php } ?>
        <tr>
          <td>Login :</td>
          <td> <input type="text" name="login"> </td>
        </tr>
        <tr>
          <td>Password :</td>
          <td> <input type="password" name="pass" autocomplete="off"> </td>
        </tr>
      </table>
      <input type="submit" value="OK" id="OK">
    </form>
    </div>
</form>