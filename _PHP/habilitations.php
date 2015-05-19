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
				<div class = "th1">Liste des habilitations</div>
					{$msg}
					<div class = "th2">Il y a actuellement {$nombre} habilitation(s)</div>
					
HTML
		);

		$arrayHab = Habilitation::getAllHabilitations();
		foreach ($arrayHab as $uneHab) {

			if(isset($_REQUEST['save']) && $_REQUEST['save'] == "Modifier") {
				if(isset($_REQUEST['nomHab']) && !empty($_REQUEST['nomHab'])) {
					$uneHab->setNomHabilitation($_REQUEST['nomHab']);
					header("location: ./habilitations.php?msg=3");
	    			exit;
				}
			}
			$p->appendContent(<<<HTML
				<div class = "row bordure fond">
					<form method="post">
						<input type="text" placeholder="Nom de l'habilitation" name="nomHab" value="{$uneHab->getNomHab()}">
						<div class="boutons_objet">
							<button type="submit" class="button" onclick="effacer({$uneHab->getIdHab()})">Supprimer</button>
							<input type="submit" value="Modifier" name="save">
						</div>	
					</form> 
				</div>
HTML
			);
		}

		$p->appendToJs(<<<JAVASCRIPT
			function effacer(num)
			{
				var confirm = window.confirm(\"Voulez-vous supprimer cette habilitation ?\");
				if (confirm)
					document.location.href=\"./habilitations.php?i=\" + num + \"&delete=yes\";
			};
JAVASCRIPT			
		);	

		$p->appendContent(<<<HTML			
				<button type="submit" onclick="history.back()" class="button">Retour</button>
			</div>	
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