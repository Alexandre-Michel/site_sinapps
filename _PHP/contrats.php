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

	$listeEntp = "";
	$pour = "";

	

	if ($user->estHabilite()) {
		$listeEntp = "<br/><br/><form><select name='id_entp'><option value=0>Tous</option>";
		$arrayEntp = Entreprise::getAllEntreprisesTab();
		foreach ($arrayEntp as $uneEntp) {
			if(isset($_REQUEST['id_entp'])) {
				if ($_REQUEST['id_entp'] == $uneEntp->getIdEntreprise())
					$listeEntp .= "<option selected value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
				else {
					$listeEntp .= "<option value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
				}
				$et = Entreprise::createEntrepriseFromId($_REQUEST['id_entp']);
				$pour = "pour l'entreprise {$et->getNomEntreprise()}";
			}			
			else {
				$listeEntp .= "<option value='{$uneEntp->getIdEntreprise()}'>{$uneEntp->getNomEntreprise()}</option>";
			}
		}
		$listeEntp .= "</select><br/><input type='submit' value='Restreindre'></form>";

	}



	$p->appendContent(<<<HTML
		<div class="content">
			<div class = "th1">Liste des contrats {$pour}</div>
			{$msg}
			{$listeEntp}
HTML
	);

	if($user->estHabilite()) {
		if ($_REQUEST['id_entp'] == 0) {
				header('location: ./contrats.php');
				exit;
			}
			else {
				$p->appendContent(Incident::getIncidentsByIdEntp($_REQUEST['id_entp']));
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