<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>comptable</title>
	<link href="ressource/style_general.css" type="text/css" rel="stylesheet">
</head>
<body>
	<header id="header">
        <a href="ressource/deconnexion.php" id="deco">Se deconnecter</a>
		<h1 id="titre">Page Comptable</h1>
		<nav id="tableNavigation" class="cb">
			<ul class="MainMenu">
				<li><input type="image" src="ressource/traiterDemande.png" style="outline:none" id="demande_a_traiter" class="rubrique" width="300"/></li>
                <li><input type="image" src="ressource/demandeTraitee.png" style="outline:none" id="demande_traitee" class="rubrique" width="300"/></li>
				<li><input type="image" src="ressource/faireDemande.png" style="outline:none" id="demande_frais" class="rubrique" width="300"/></li>
                <li><input type="image" src="ressource/visionnerHistorique.png" style="outline:none" id="visionner_historique" class="rubrique" width="300"/></li>
			</ul>
		</nav>
	</header>
	<div id="mainContener">
			
	</div>
		
	<script type="text/javascript">
		$('.rubrique').click(function() {
			var page = $(this).attr('id');
					
			$('#mainContener').fadeOut(500, function() {
				$(this).load('ressource/'+page+'.php').fadeIn(500);
			});
		});
            
        $('.rubrique').mouseenter( function(){
            if(!$(this).hasClass('select')){
                    $(this).animate({ "left": "+=50%" }, "fast" );
            }
        });
            
        $('.rubrique').mouseleave( function(){
            if(!$(this).hasClass('select')){
                $(this).animate({ "left": "-=50%" }, "fast" );
            }
        });
            
        var $precedenteSelect = '';
        $('.rubrique').click( function() {
            if(!$(this).hasClass('select')){
                if($(this)!=$precedenteSelect){
                        $(this).css('margin-left','-80%');
                        $(this).toggleClass('select');
                    if($precedenteSelect!=''){
                        $precedenteSelect.toggleClass('select');
                        $precedenteSelect.animate({ "left": "-=50%" }, "fast" );
                    }
                }
                $precedenteSelect=$(this);
            }
        });
                
                
            
        function height(bloc){
	        var hauteur;
	
	        if( typeof( window.innerWidth ) == 'number' )
		        hauteur = window.innerHeight;
	        else if( document.documentElement && document.documentElement.clientHeight )
		        hauteur = window.innerHeight;
	        document.getElementById('tableNavigation').style.height = hauteur+"px";
        }

        window.onload = function(){ height("page") };
        window.onresize = function(){ height("page") };
        
	</script>
     <?php session_start();
    include_once './ressource/verifCompta.php'; ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</body>
</html>