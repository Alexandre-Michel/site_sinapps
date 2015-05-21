<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Incident.class.php';
require_once 'Entreprise.class.php';
require_once 'Type_incident.class.php';
require_once 'Parc.class.php';

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

	$msg = "";

	if(isset($_REQUEST['i'])) {
		if(isset($_REQUEST['delete'])) {
			try {
    			Incident::deleteIncident($_REQUEST['i']);
    			header("location: ./incidents.php?msg=1");
    			exit;
    		}
    		catch (Exception $e) {
    			header("location: ./incidents.php?msg=2");
    			exit;	    			
    		}
		}

	}

	if(isset($_REQUEST['msg'])) {
		if($_REQUEST['msg'] == 1) {
			$msg = "<div class='succes'>Incident supprimé avec succès.</div>";
		}
		else if($_REQUEST['msg'] == 2) {
			$msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
		}
	}

	$listeEntp = "<br/><br/><form><select name='id_entp'><option value=0>Tous</option>";
	$arrayEntp = Entreprise::getAllEntreprisesTab();
	foreach ($arrayEntp as $uneEntp) {
		if(isset($_REQUEST['id_entp'])) {
			if ($_REQUEST['id_entp'] == $uneEntp->getIdEntreprise())
				$listeEntp .= "<option selected value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
			else {
			$listeEntp .= "<option value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
			}
		}			
		else {
			$listeEntp .= "<option value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
		}
	}
	$listeEntp .= "</select><br/><input type='submit' value='Restreindre'></form>";

	$p->appendContent(<<<HTML
		<div class="content">
			<div class = "th1">Liste des incidents</div>
				{$msg}
				<div class = "th2">Il y a actuellement {$nombre} incident(s) dont {$nbActifs} actif(s)</div>
				{$listeEntp}
HTML
	);

	if ($droit == 1) {
		if(isset($_REQUEST['id_entp']) && $_REQUEST['id_entp'] != "") {
			if ($_REQUEST['id_entp'] == 0) {
				header('location: ./incidents.php');
				exit;
			}
			else {
				$p->appendContent(Incident::getIncidentsByIdEntp($_REQUEST['id_entp']));
			}		
		}
		else {
			$p->appendContent(Incident::getAllIncident());	
		}
		
	}
	else {
		$p->appendContent(Incident::getIncidentByPers($user->getIdPers()));

	}


	$p->appendContent(<<<HTML
			<input type="button" name="retour" value="Retour" onclick="history.back()">
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