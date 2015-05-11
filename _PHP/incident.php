<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'incident.class.php';

$p = new WebPage("Détail de l'incident - Sinapp's");

try {
	$user = Personne::createFromSession();
	if (isset($_GET['i']) && !empty($_GET['i'])) {
		try {
			$incident = Incident::createIncidentFromId($_GET['i']);
			if ($incident->getIdPersonne() == $user->getIdPers() || $user->getIdHabilitation() == 1) {
				$status = "";
				switch($incident->getStatutIncident()) {
					case 0 : 
					$status = "Non traité";
					break;
					case 1 :
					$status = "En cours de traitement";
					break;
					case 2 :
					$status = "Résolu !";
					break;		
				}
				$p->appendContent(<<<HTML
					<div class="content">
						{$incident->getNomIncident()}<br/><br/>
						{$incident->getDescriptionIncident()}<br/>
						{$incident->getDateIncident()}<br/>	
						{$status}
					</div>
HTML
				);				
			}
			else {
				header('location: ./index.php');
				exit;
			}
		}
		catch (Exception $e) {
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