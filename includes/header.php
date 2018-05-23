<?php
if (!isset($titrePage))
    $titrePage = "";

$nomFichier = getNomFichier();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Alexis"

              

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style>
            body {
                padding-top: 50px;
            }
        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <iframe align="left" name="date du jour" id="date-du-jour" style="width:95px;height:65px;" src="http://www.mathieuweb.fr/calendrier/date-jour-noir-bleu.html" scrolling="no" frameborder="0" allowtransparency="true"></iframe>

                    <a class="navbar-brand" href="connection.php">Gestion des frais</a>
                </div>

                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">

                        <?php if (isConnected()) : ?>
                            <li><a href="deconnexion.php">Se déconnecter</a></li>
<?php endif; ?>

                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">