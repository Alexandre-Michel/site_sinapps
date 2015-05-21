<?php

require_once 'webpage.class.php';
require_once 'Personne.class.php';
require_once 'Contrat.class.php';
require_once 'Entreprise.class.php';
require_once 'Offre.class.php';
require_once 'Personne.class.php';

$p = new WebPage("Membres - Sinapp's");


try {
    // Lecture depuis les données de session
    $user = Personne::createFromSession();
    
    if ($user->estHabilite()) {

    	$msg = "";

    	if(isset($_REQUEST['i'])) {
    		if(isset($_REQUEST['delete'])) {
    			try {
	    			Personne::deletePersonne($_REQUEST['i']);
	    			header("location: ./membres.php?msg=1");
	    			exit;
	    		}
	    		catch (Exception $e) {
	    			header("location: ./membres.php?msg=2");
	    			exit;	    			
	    		}
    		}

    	}

    	if(isset($_REQUEST['msg'])) {
    		if($_REQUEST['msg'] == 1) {
    			$msg = "<div class='succes'>Membre supprimée avec succès.</div>";
    		}
    		else if($_REQUEST['msg'] == 2) {
    			$msg = "<div class='rate'>Echec, veuillez réessayer.</div>";
    		}
    	}

		$p->appendContent(<<<HTML
			<div class="content">
				<div class = "th1">Liste des membres</div>
				{$msg}
				<form>
					<br/><input type="text" name="nom" placeholder="Rechercher une personne..."><br/>
					<input type="submit" value="Rechercher">
				</form>	
HTML
		);

		if(isset($_REQUEST['nom']) && $_REQUEST['nom']) {	
			$p->appendContent(Personne::getPersonnesWithName($_REQUEST['nom']));
		}
		else {
			$p->appendContent(Personne::getAllPersonne());
		}

		$p->appendContent(<<<HTML
				<input type="button" name="retour" value="Retour" onclick="history.back()">
			</div>
HTML
		);
	}

	else {
		header('location: ./index.php');
		exit;
	}
}

catch (notInSessionException $e) {
    // Pas d'utilisateur connecté
    header("Location: ./connexion.php") ;
    exit;
}

echo $p->toHTML();