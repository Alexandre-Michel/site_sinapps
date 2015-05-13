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
				
				if (isset($_REQUEST['poster']) && $_REQUEST['poster'] == "Poster") {
					if (isset($_REQUEST['commentaire']) && !empty($_REQUEST['commentaire'])) {
						$com = $_REQUEST['commentaire'];			
						if ($user->estHabilite()) {
							Action::createAction($com , 0, $user->getIdPers(), $incident->getIdIncident(), 1);
						}
						else {
							Action::createAction($com, 0, $user->getIdPers(), $incident->getIdIncident(), 4);

						}
						header("location: ./incident.php?i={$incident->getIdIncident()}");
						exit;
					}					
				}
				
				switch($incident->getStatutIncident()) {
					case 0 : 
					$status = "Non traité";
					break;
					case 1 :
					$status = "En cours de traitement";
					$traitement = "<form method='post'><div class = 'row'><textarea id='textIncident' rows=8 placeholder=\"Votre commentaire ici...\" name=\"commentaire\"></textarea></div>
						<div class = 'row'><input type='submit' value='Poster' name='poster'></div></form>";
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
						<div class="row th2">{$status}<br/></div>
						<div class="row">
							<div class="left">
								<div class = "th2">{$incident->getNomIncident()}</div>
								<div class ="message">{$incident->getDescriptionIncident()}</div>
								<div class = "date_action">{$incident->getDateIncident()}</div>	
							</div>		
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
								<input type="button" name="retour" value="Retour" onclick="history.back()">
							</form>	
						</div>
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
			header('location: ./index.php?msg=5');
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