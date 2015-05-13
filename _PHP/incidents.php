<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Incident.class.php';

$p = new WebPage("Incidents - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
    $nombre = 0;
    $nbActifs = 0;
    switch ($user->getIdHabilitation()) {
		// Si l'utilisateur est un administrateur
		case 1:
		$droit = 1;
		$nombre = Incident::getNbIncidents();
		$nbActifs = Incident::getNbIncidentsActifs();
		break;
		//Si l'utilisateur n'est qu'un membre lambda sans droits
		case 2:
		$droit = 2;
		$nombre = Incident::getNbIncidentsByPers($user->getIdPers());
		$nbActifs = Incident::getNbIncidentsActifsByPers($user->getIdPers());
		break;
	}

	$p->appendContent(<<<HTML
		<div class="content">
			<div class = "th1">Liste des incidents</div>
				<div class = "th2">Il y a actuellement {$nombre} incident(s) dont {$nbActifs} actif(s)</div>
HTML
	);

	if ($droit == 1) {
		$p->appendContent(Incident::getAllIncident());
	}
	else {
		$p->appendContent(Incident::getIncidentByPers($user->getIdPers()));

	}


	$p->appendContent(<<<HTML
		</div>
HTML
	);
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    die() ;
}

echo $p->toHTML();