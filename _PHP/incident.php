<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'incident.class.php';
require_once 'action.class.php';

$p = new WebPage("Détail de l'incident - Sinapp's");

try {
	$user = Personne::createFromSession();
	if (isset($_GET['i']) && !empty($_GET['i'])) {
		try {
			$incident = Incident::createIncidentFromId($_GET['i']);
			if ($incident->getIdPersonne() == $user->getIdPers() || $user->getIdHabilitation() == 1) {
				$status = "";
				$traitement = "";
				$champsAdmin = "";
				switch($incident->getStatutIncident()) {
					case 0 : 
					$status = "Non traité";
					break;
					case 1 :
					$status = "En cours de traitement";
					$traitement = "<form method='post'><div class = 'row'><textarea rows=8 placeholder=\"Votre commentaire ici...\" name=\"commentaire\"></textarea></div>
						<div class = 'row'><input type='submit' value='Poster' name='commentaire'></div></form>";
					if ($user->estHabilite()) {
						$champsAdmin = "";
					}
					break;
					case 2 :
					$status = "Résolu !";
					break;		
				}

				$p->appendContent(<<<HTML
					<div class="content">
						<div class="row th1">Détail de l'incident n°{$incident->getIdIncident()}</div>
						<div class="row">
							{$incident->getNomIncident()}<br/><br/>
							{$incident->getDescriptionIncident()}<br/>
							{$incident->getDateIncident()}<br/>	
							{$status}<br/>
						</div>
HTML
				);		


				$p->appendContent(Action::getActionsByIdIncident($incident->getIdIncident()));	

				$p->appendContent(<<<HTML
						<div class="row">	
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
					$option = "<select name=\"statut\">
						<option name=\"statut\" value=0>Non traité</option>
						<option name=\"statut\" value=1>En cours de traitement</option>
						<option name=\"statut\" value=2>Résolu</option>
						</select>";
				}
				else {
					if ($incident->getStatutIncident() == 2) {
						$option = "<label for name=\"statut\">Résolu</label><input type=\"checkbox\" value=2 checked='checked' name=\"statut\">";
					}
					else {
						$option = "<label for name=\"statut\">Résolu</label><input type=\"checkbox\" value=2 name=\"statut\">";
					}
				}

				$p->appendContent(<<<HTML
						<div class="row">
							<form method="post">
								{$option}								
								<input type="submit" name="modifier" value="Modifier"> 
							</form>	
						</div>
					</div>
HTML
				);


				if (isset($_REQUEST['commentaire']) && $_REQUEST['commentaire'] == "Poster") {	
					if ($user->estHabilite()) {
						Action::createAction($user->getIdPers(), $incident->getIdIncident(), 1);
					}
					else {
						Action::createAction($user->getIdPers(), $incident->getIdIncident(), 4);
					}
					header("location: ./incident.php?i={$incident->getIdIncident()}");
					exit;					
				}	

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