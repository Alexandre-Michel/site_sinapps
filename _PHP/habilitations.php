<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Habilitation.class.php';


$p = new WebPage("Habilitations - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

    if ($user->estHabilite()) {

		$msg = "";
		$nombre = Habilitation::getNbHabilitations();

		if(isset($_REQUEST['i'])) {
			if(isset($_REQUEST['delete'])) {
				try {
	    			Habilitation::deleteHabilitation($_REQUEST['i']);
	    			header("location: ./habilitations.php?msg=1");
	    			exit;
	    		}
	    		catch (Exception $e) {
	    			header("location: ./habilitations.php?msg=2");
	    			exit;	    			
	    		}
			}

		}



		if(isset($_REQUEST['msg'])) {
			if($_REQUEST['msg'] == 1) {
				$msg = "<div class='succes'>Habilitation supprimée avec succès.</div>";
			}
			else if($_REQUEST['msg'] == 2) {
				$msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
			}
			else if($_REQUEST['msg'] == 3) {
				$msg = "<div class='succes'>Habilitation modifiée avec succès.</div>";
			}
		}

		$p->appendContent(<<<HTML
			<div class="content">
				<div class = "th1">
					Liste des habilitations
				</div>
				{$msg}
				<div class = "th2">
					Il y a actuellement {$nombre} habilitation(s)
				</div>
				<div class= "box1">
					
HTML
		);


		$arrayHab = Habilitation::getAllHabilitations();
		foreach ($arrayHab as $uneHab) {

		if(isset($_REQUEST['save']) && $_REQUEST['save'] == "Sauvegarder") {
			if(isset($_REQUEST['nomHab']) && !empty($_REQUEST['nomHab'])) {
				$uneHab->setNomHab($_REQUEST['nomHab']);
				header("location: ./habilitations.php?msg=3");
			}
		}
			$p->appendContent(<<<HTML
					<div class = "row bordure fond">
							<div>{$uneHab->getNomHab()}</div>
							<div class="boutons_objet">
								<input class="button" type="submit" onclick="modifier({$uneHab->getIdHab()})" value="Modifier">
								<input class="button" type="submit" onclick="effacer({$uneHab->getIdHab()})" value="Supprimer">
							</div>	
						
					</div>	
HTML
			);
		}

		$p->appendContent(<<<HTML
				</div>
				<button type="submit" onclick="history.back()" class="button">Retour</button>
			</div>	
			<script>
				function effacer(num)
				{
					var confirm = window.confirm("Voulez-vous supprimer cette habilitation ?");
					if (confirm)
						document.location.href='./habilitations.php?i=' + num + '&delete=yes';
				};
				
				function modifier(num)
				{
					document.location.href='./habilitation.php?i=' + num;
				};
			</script>
HTML
		);
	}
	else {
		header("Location: ./index.php") ;
    	exit;
	}
}
catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();