<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'incident.class.php';

$p = new WebPage("Détail de l'incident - Sinapp's");

try {
	$user = Personne::createFromSession();
	if (isset($_GET['i']) && empty($_GET['i'])) {
		$incident = Incident::createIncidentFromId($_GET['i']);
		if ($incident->getIdPersonne() == $user->getIdPers()) {
			$p->appendContent(<<<HTML
				<div class="content">
					{$incident->getNomIncident()}
					{$incident->getDescriptionIncident()}
					{$incident->getDateIncident()}	
				</div>
HTML
			);				
		}
		else {
			header('location: ./index.php');
			exit;
		}
	}
	else {
		header('location: ./incidents.php');
		exit;
	}
}
catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();