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
				$traitement = "";
				switch($incident->getStatutIncident()) {
					case 0 : 
					$status = "Non traité";
					if ($user->estHabilite()) {
						$traitement = "<button onclick=\"location.href='./traiterIncident.php?id={$incident->getIdIncident()}'\">Traiter</button>";
					}
					break;
					case 1 :
					$status = "En cours de traitement";
					$traitement = "<button onclick=\"location.href='./traiterIncident.php?id={$incident->getIdIncident()}'\">Poster un commentaire</button>";
					break;
					case 2 :
					$status = "Résolu !";
					break;		
				}

				$p->appendContent(<<<HTML
					<div class="content">
HTML
				);	

				$p->appendContent(<<<HTML
					<div class="row th1">Détail de l'incident n°{$incident->getIdIncident()}</div>
					<div class="row">
						{$incident->getNomIncident()}<br/><br/>
						{$incident->getDescriptionIncident()}<br/>
						{$incident->getDateIncident()}<br/>	
						{$status}<br/>
						{$traitement}
					</div>
HTML
				);		

				if(isset($_POST['modifier']) && $_POST['modifier'] == 'Modifier') {
						$incident->setStatutIncident($_REQUEST['statut']);
						header("location: ./incident.php?i={$incident->getIdIncident()}");
						exit;
				}

				$option = "";
				if ($user->estHabilite()) {
					$option = "<option name=\"statut\" value=1>En cours de traitement</option>";
				}

				$p->appendContent(<<<HTML
					<div class="row">
						<form method="post">
							<select name="statut">							
								<option name="statut" value=0>Non traité</option>
								{$option}
								<option name="statut" value=2>Résolu</option>
							</select>
							<input type="submit" name="modifier" value="Modifier"> 
						</form>	
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