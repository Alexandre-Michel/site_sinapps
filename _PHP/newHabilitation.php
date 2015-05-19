<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Habilitation.class.php';

$p = new WebPage("Nouvel Incident - Sinapp's");

try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

	if($user->estHabilite()) {
		
	
		$msg = ""; 
		if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "Soumettre") {
			if(isset($_REQUEST['nom']) && $_REQUEST['nom'] != "") {
				Habilitation::createHabilitation($_REQUEST['nom']);
				$msg = 1;
				header("location: ./newHabilitation.php?msg={$msg}");
				exit;
			}
			else {
				$msg = 2;
				header("location: ./newHabilitation.php?msg={$msg}");
				exit;
			}
		}
		
		if (isset($_GET["msg"]) && $_GET["msg"] != "") {
			if ($_GET["msg"] == 1) $msg = "<div class='succes'>Habilitation créée avec succès.</div>";
			else if ($_GET["msg"] == 2) $msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
		}
		
		$p->appendContent(<<<HTML
			<div class="content">
				<div class="th1">Nouvelle Habilitation</div>
				{$msg}
				<form method="post"> 
					<input type="text" required placeholder="Nom de l'habilitation" name="nom"/><br/>	
					<input type="submit" name="submit" value="Soumettre">
				</form>
				<input type="button" name="retour" value="Retour" onclick="history.back()">
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