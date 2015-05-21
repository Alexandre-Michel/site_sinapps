<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'Offre.class.php';

$p = new WebPage("Contrats - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();

	$msg = "";

	if(isset($_REQUEST['i'])) {
		if(isset($_REQUEST['delete'])) {
			try {
    			Contrat::deleteContrat($_REQUEST['i']);
    			header("location: ./contrats.php?msg=1");
    			exit;
    		}
    		catch (Exception $e) {
    			header("location: ./contrats.php?msg=2");
    			exit;	    			
    		}
		}

	}

	if(isset($_REQUEST['msg'])) {
		if($_REQUEST['msg'] == 1) {
			$msg = "<div class='succes'>Contrat supprimé avec succès.</div>";
		}
		else if($_REQUEST['msg'] == 2) {
			$msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
		}
	}

	$p->appendContent(<<<HTML
		<div class="content">
			<div class = "th1">Liste des contrats</div>
			{$msg}
			{$listeEntp}
HTML
	);

	if ($user->estHabilite()) {
		$listeEntp = "";
		$listeEntp = "<br/><br/><form><select name='id_entp'><option value=0>Tous</option>";
		$arrayEntp = Entreprise::getAllEntreprisesTab();
		foreach ($arrayEntp as $uneEntp) {
			if(isset($_REQUEST['id_entp'])) {
				if ($_REQUEST['id_entp'] == $uneEntp->getIdEntreprise())
					$listeEntp .= "<option selected value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
				else {
				$listeEntp .= "<option value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
				}
				$nombre = Incident::getNbIncidentsByIdEntp($_REQUEST['id_entp']);
				$nbActifs = Incident::getNbIncidentsActifsByIdEntp($_REQUEST['id_entp']);
			}			
			else {
				$listeEntp .= "<option value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
			}
		}
		$listeEntp .= "</select><br/><input type='submit' value='Restreindre'></form>";

		if(isset($_REQUEST['id_entp'])) {
			$p->appendContent(Contrat::getContratByIdEntp($_REQUEST['id_entp']));
		}
		else {
			$p->appendContent(Contrat::getAllContrats());
		}
	}

	else {
		if ($user->getIdEntpPers() == NULL) {
			header("Location: ./perso.php") ;
			exit;
		}
		$entp = Entreprise::createEntrepriseFromId($user->getIdEntpPers());
		$p->appendContent(Contrat::getContratByIdEntp($entp->getIdEntreprise()));
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
    exit;
}

echo $p->toHTML();